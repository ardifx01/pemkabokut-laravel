<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Business;
use App\Models\Document;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Mengambil data statistik untuk dashboard
        $statistics = [
            'visitors' => 1294, // Ini bisa diganti dengan data real dari analytics
            'subscribers' => User::count(),
            'sales' => 1345, // Ini bisa diganti dengan data real dari sales
            'orders' => Business::count(), // Menggunakan jumlah UMKM sebagai orders
        ];

        // Data untuk chart (contoh data, bisa diganti dengan data real)
        $userStats = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => [400, 300, 400, 500, 400, 300, 400, 500, 600, 700, 800, 900],
                ],
                [
                    'label' => 'Sessions',
                    'data' => [200, 250, 200, 300, 250, 200, 250, 300, 350, 400, 450, 500],
                ],
                [
                    'label' => 'Bounce Rate',
                    'data' => [150, 180, 150, 200, 180, 150, 180, 200, 220, 250, 280, 300],
                ]
            ]
        ];

        $dailySales = [
            'labels' => ['Mar 25', 'Mar 26', 'Mar 27', 'Mar 28', 'Mar 29', 'Mar 30', 'Mar 31', 'Apr 01', 'Apr 02'],
            'data' => [3000, 3200, 3100, 3400, 3300, 3500, 3800, 4200, 4578],
            'total' => 4578.58
        ];

        // Get recent businesses for the dashboard
        $recentBusinesses = Business::with('user')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('statistics', 'userStats', 'dailySales', 'recentBusinesses'));
    }

    /**
     * Get dashboard statistics for AJAX requests.
     */
    public function getStatistics()
    {
        $statistics = [
            'visitors' => 1294,
            'subscribers' => User::count(),
            'posts' => Post::count(),
            'businesses' => Business::count(),
            'documents' => Document::count(),
        ];

        return response()->json($statistics);
    }

    /**
     * Get user statistics data for charts.
     */
    public function getUserStats()
    {
        // Ini bisa diganti dengan query yang lebih kompleks untuk mendapatkan data real
        $userStats = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                        ->whereYear('created_at', date('Y'))
                        ->groupBy('month')
                        ->pluck('count', 'month')
                        ->values()
                        ->toArray()
                ]
            ]
        ];

        return response()->json($userStats);
    }
}
