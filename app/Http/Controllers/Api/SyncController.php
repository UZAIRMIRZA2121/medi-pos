<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SyncController extends Controller
{
    /**
     * Receive local changes and apply them to the cloud database
     */
    public function push(Request $request)
    {
        // Simple authentication can be added here
        
        $payload = $request->input('payload', []);
        
        DB::beginTransaction();
        try {
            foreach ($payload as $table => $records) {
                foreach ($records as $record) {
                    $exists = DB::table($table)->where('id', $record['id'])->exists();
                    
                    if ($exists) {
                        DB::table($table)->where('id', $record['id'])->update($record);
                    } else {
                        DB::table($table)->insert($record);
                    }
                }
            }
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Send cloud changes down to the local database
     */
    public function pull(Request $request)
    {
        $lastSync = $request->input('last_sync', '1970-01-01 00:00:00');
        
        $tables = ['categories', 'suppliers', 'customers', 'medicines', 'sales', 'sale_items', 'expenses', 'purchase_orders', 'purchase_order_items'];
        $changes = [];

        foreach ($tables as $table) {
            $records = DB::table($table)
                ->where('updated_at', '>', $lastSync)
                ->get();
                
            if ($records->isNotEmpty()) {
                $changes[$table] = $records;
            }
        }

        return response()->json([
            'status' => 'success',
            'changes' => $changes,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Verify credentials against the cloud database for new local logins
     */
    public function verifyLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'success',
                'user' => $user->toArray()
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials on live server.'
        ], 401);
    }
}
