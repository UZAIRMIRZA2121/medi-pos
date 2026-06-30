<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Privilege;

class PrivilegeSeeder extends Seeder
{
    public function run(): void
    {
        $privileges = [
            ['name' => 'Dashboard', 'slug' => 'dashboard', 'group' => 'Overview'],
            ['name' => 'POS / Billing', 'slug' => 'pos', 'group' => 'Sales'],
            ['name' => 'Invoices', 'slug' => 'invoices', 'group' => 'Sales'],
            ['name' => 'Sales History', 'slug' => 'sales_history', 'group' => 'Sales'],
            ['name' => 'Expenses', 'slug' => 'expenses', 'group' => 'Sales'],
            ['name' => 'Medicines', 'slug' => 'medicines', 'group' => 'Inventory'],
            ['name' => 'Categories', 'slug' => 'categories', 'group' => 'Inventory'],
            ['name' => 'Stock & Expiry Alerts', 'slug' => 'alerts', 'group' => 'Inventory'],
            ['name' => 'Purchase Orders', 'slug' => 'purchase_orders', 'group' => 'Inventory'],
            ['name' => 'Suppliers', 'slug' => 'suppliers', 'group' => 'Contacts'],
            ['name' => 'Customers', 'slug' => 'customers', 'group' => 'Contacts'],
            ['name' => 'Staff', 'slug' => 'staff', 'group' => 'Contacts'],
            ['name' => 'Store Settings', 'slug' => 'settings_store', 'group' => 'Settings'],
            ['name' => 'My Profile', 'slug' => 'profile', 'group' => 'Settings'],
        ];

        foreach ($privileges as $privilege) {
            Privilege::updateOrCreate(['slug' => $privilege['slug']], $privilege);
        }
    }
}
