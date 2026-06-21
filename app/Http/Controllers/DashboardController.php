<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Category;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMedicines = Medicine::count();
        $totalCategories = Category::count();
        
        $lowStockCount = Medicine::whereColumn('stock_quantity', '<=', 'low_stock_level')->count();
        $expiredCount = Medicine::whereDate('expiry_date', '<', Carbon::today())->count();
        
        $todaySalesSum = Sale::whereDate('created_at', Carbon::today())->sum('grand_total');
        $totalInvoices = Sale::count();
        
        $totalSales = Sale::sum('grand_total');
        $totalExpense = \App\Models\Expense::where('store_id', auth()->id())->sum('amount');
        $totalEarning = $totalSales - $totalExpense;
        
        $recentSales = Sale::with('customer')->orderBy('created_at', 'desc')->take(8)->get();
        
        $lowStockItems = Medicine::whereColumn('stock_quantity', '<=', 'low_stock_level')->take(5)->get();
        
        $expiringItems = Medicine::whereDate('expiry_date', '>=', Carbon::today())
            ->whereDate('expiry_date', '<=', Carbon::today()->addDays(30))
            ->take(5)
            ->get();
            
        $subscription = \App\Models\Subscription::with('package')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest()
            ->first();
            
        return view('dashboard.index', compact(
            'totalMedicines', 'totalCategories', 'lowStockCount', 'expiredCount',
            'todaySalesSum', 'totalInvoices', 'recentSales', 'lowStockItems', 'expiringItems',
            'subscription', 'totalSales', 'totalExpense', 'totalEarning'
        ));
    }
}
