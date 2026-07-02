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
        $request->validate(['user_id' => 'required']);
        $userId = $request->input('user_id');
        $payload = $request->input('payload', []);

        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user || !$user->sync_access) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized: Sync Access Revoked by Super Admin.'], 403);
        }
        
        DB::beginTransaction();
        try {
            foreach ($payload as $table => $records) {
                foreach ($records as $record) {
                    // Security: Enforce correct tenant ID
                    if (in_array($table, ['categories', 'medicines', 'suppliers', 'customers', 'sales', 'purchase_orders', 'staff', 'business_settings', 'print_settings'])) {
                        $record['user_id'] = $userId;
                    } elseif ($table === 'expenses') {
                        $record['store_id'] = $userId;
                    }

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
        $request->validate(['user_id' => 'required']);
        $userId = $request->input('user_id');
        $lastSync = $request->input('last_sync', '1970-01-01 00:00:00');

        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user || !$user->sync_access) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized: Sync Access Revoked by Super Admin.'], 403);
        }
        
        $tables = ['categories', 'suppliers', 'customers', 'medicines', 'sales', 'expenses', 'purchase_orders', 'staff', 'business_settings', 'print_settings'];
        $changes = [];

        foreach ($tables as $table) {
            $query = DB::table($table)->where(function($q) use ($lastSync) {
                $q->whereNull('last_synced_at')
                  ->orWhere('updated_at', '>', $lastSync);
            });

            if ($table === 'expenses') {
                $query->where('store_id', $userId);
            } else {
                $query->where('user_id', $userId);
            }

            $records = $query->get();
                
            if ($records->isNotEmpty()) {
                $changes[$table] = $records;
            }
        }

        // Handle items which depend on parent tables
        $saleItems = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.user_id', $userId)
            ->where(function($q) use ($lastSync) {
                $q->whereNull('sale_items.last_synced_at')
                  ->orWhere('sale_items.updated_at', '>', $lastSync);
            })
            ->select('sale_items.*')
            ->get();
        if ($saleItems->isNotEmpty()) {
            $changes['sale_items'] = $saleItems;
        }

        $poItems = DB::table('purchase_order_items')
            ->join('purchase_orders', 'purchase_order_items.purchase_order_id', '=', 'purchase_orders.id')
            ->where('purchase_orders.user_id', $userId)
            ->where(function($q) use ($lastSync) {
                $q->whereNull('purchase_order_items.last_synced_at')
                  ->orWhere('purchase_order_items.updated_at', '>', $lastSync);
            })
            ->select('purchase_order_items.*')
            ->get();
        if ($poItems->isNotEmpty()) {
            $changes['purchase_order_items'] = $poItems;
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
            $userData = $user->toArray();
            $userData['password'] = $user->password; // Explicitly include hashed password

            return response()->json([
                'status' => 'success',
                'user' => $userData
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials on live server.'
        ], 401);
    }

    /**
     * Verify staff credentials against the cloud database for new local logins
     */
    public function verifyStaff(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $staff = \App\Models\Staff::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if ($staff) {
            $user = \App\Models\User::find($staff->user_id);
            if ($user) {
                $userData = $user->toArray();
                $userData['password'] = $user->password;

                return response()->json([
                    'status' => 'success',
                    'staff' => $staff->toArray(),
                    'user' => $userData
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid staff credentials on live server.'
        ], 401);
    }
}
