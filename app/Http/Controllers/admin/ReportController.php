<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Movie;
use App\Models\MovieTheater;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month'); // có thể null

        // Query theo tháng/năm
        $query = Order::query();
        if ($month) {
            $query->whereYear('date_order', $year)
                ->whereMonth('date_order', $month);
        } else {
            $query->whereYear('date_order', $year);
        }

        // Thống kê chính
        $totalRevenue = $query->sum('total_order');
        $totalOrders  = $query->count();
        $totalTickets = DB::table('order_details')
            ->whereIn('order_id', $query->pluck('id'))
            ->count();

        $usersCount   = User::count();
        $moviesCount  = Movie::count();
        $theatersCount = MovieTheater::count();

        // Thống kê lượt thích & rate TB
        $avgRate      = DB::table('movie_rates')->avg('user_rate');
        $likesCount   = DB::table('movie_likes')->count();

        // Doanh thu theo tháng (để vẽ chart)
        $monthlyRevenueRaw = Order::select(
            DB::raw('MONTH(date_order) as month'),
            DB::raw('SUM(total_order) as revenue')
        )
            ->whereYear('date_order', $year)
            ->groupBy('month')
            ->pluck('revenue', 'month');

        $monthlyRevenue = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyRevenue[$m] = $monthlyRevenueRaw[$m] ?? 0;
        }

        return view('admin.pages.reports.index', compact(
            'year',
            'month',
            'totalRevenue',
            'totalOrders',
            'totalTickets',
            'usersCount',
            'moviesCount',
            'theatersCount',
            'avgRate',
            'likesCount',
            'monthlyRevenue'
        ));
    }
}
