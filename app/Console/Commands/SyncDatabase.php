<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class SyncDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the local database with the live cloud server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting sync process...");

        // Determine if there is internet
        if (!$this->checkInternet()) {
            $this->error("No internet connection detected. Skipping sync.");
            return;
        }

        $apiUrl = config('app.cloud_api_url', 'http://127.0.0.1:8000/api');
        $tables = ['categories', 'suppliers', 'customers', 'medicines', 'sales', 'sale_items', 'expenses', 'purchase_orders', 'purchase_order_items'];

        // ==========================================
        // 1. PUSH LOCAL CHANGES TO CLOUD
        // ==========================================
        $this->info("Pushing local changes...");
        $payload = [];

        foreach ($tables as $table) {
            // Find records that have never been synced OR have been updated since they were last synced
            $records = DB::table($table)
                ->whereNull('last_synced_at')
                ->orWhereColumn('updated_at', '>', 'last_synced_at')
                ->get();
                
            if ($records->isNotEmpty()) {
                $payload[$table] = $records;
            }
        }

        if (!empty($payload)) {
            try {
                $response = Http::post($apiUrl . '/sync/push', ['payload' => $payload]);
                
                if ($response->successful()) {
                    $this->info("Push successful. Updating local sync timestamps...");
                    $now = now();
                    foreach ($payload as $table => $records) {
                        $ids = $records->pluck('id')->toArray();
                        DB::table($table)->whereIn('id', $ids)->update(['last_synced_at' => $now]);
                    }
                } else {
                    $this->error("Cloud API returned an error during push.");
                }
            } catch (\Exception $e) {
                $this->error("Failed to connect to Cloud API for pushing: " . $e->getMessage());
            }
        } else {
            $this->info("No local changes to push.");
        }

        // ==========================================
        // 2. PULL CLOUD CHANGES TO LOCAL
        // ==========================================
        $this->info("Pulling cloud changes...");
        // Get the latest last_synced_at across all tables to ask the cloud for anything newer
        $latestSync = '1970-01-01 00:00:00';
        foreach ($tables as $table) {
            $max = DB::table($table)->max('last_synced_at');
            if ($max && $max > $latestSync) {
                $latestSync = $max;
            }
        }

        try {
            $response = Http::get($apiUrl . '/sync/pull', ['last_sync' => $latestSync]);
            
            if ($response->successful()) {
                $data = $response->json();
                $changes = $data['changes'] ?? [];
                
                if (!empty($changes)) {
                    DB::beginTransaction();
                    try {
                        foreach ($changes as $table => $records) {
                            foreach ($records as $record) {
                                // Important: We cast it to array because it comes back as array from JSON
                                $recordArr = (array) $record;
                                $recordArr['last_synced_at'] = now(); // mark as synced

                                $exists = DB::table($table)->where('id', $recordArr['id'])->exists();
                                
                                if ($exists) {
                                    DB::table($table)->where('id', $recordArr['id'])->update($recordArr);
                                } else {
                                    DB::table($table)->insert($recordArr);
                                }
                            }
                        }
                        DB::commit();
                        $this->info("Pull applied successfully.");
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $this->error("Error applying pulled data: " . $e->getMessage());
                    }
                } else {
                    $this->info("No new changes on the cloud.");
                }
            } else {
                $this->error("Cloud API returned an error during pull.");
            }
        } catch (\Exception $e) {
            $this->error("Failed to connect to Cloud API for pulling: " . $e->getMessage());
        }

        $this->info("Sync completed.");
    }

    /**
     * Check if there is an active internet connection by pinging Google
     */
    private function checkInternet()
    {
        $connected = @fsockopen("www.google.com", 80); 
        if ($connected) {
            fclose($connected);
            return true;
        }
        return false;
    }
}
