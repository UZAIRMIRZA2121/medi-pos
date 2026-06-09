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
        
        $recentSales = Sale::with('customer')->orderBy('created_at', 'desc')->take(8)->get();
        
        $lowStockItems = Medicine::whereColumn('stock_quantity', '<=', 'low_stock_level')->take(5)->get();
        
        $expiringItems = Medicine::whereDate('expiry_date', '>=', Carbon::today())
            ->whereDate('expiry_date', '<=', Carbon::today()->addDays(30))
            ->take(5)
            ->get();
            
        return view('dashboard.index', compact(
            'totalMedicines', 'totalCategories', 'lowStockCount', 'expiredCount',
            'todaySalesSum', 'totalInvoices', 'recentSales', 'lowStockItems', 'expiringItems'
        ));
    }
}
