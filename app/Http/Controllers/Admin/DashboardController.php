<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Business;
use App\Models\Document;
use App\Models\Category;
use App\Models\Headline;
use App\Models\Data;
use App\Models\File;
use App\Models\Icon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Mengambil data statistik untuk dashboard
        $statistics = [
            'categories' => Category::count(),
            'headlines' => Headline::count(),
            'posts' => Post::count(),
            'data' => Data::count(),
            'documents' => Document::count(),
            'files' => File::count(),
            'businesses' => Business::count(),
            'icons' => Icon::count(),
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

        // Get calendar events
        $calendarEvents = $this->getCalendarEventsData();

        return view('admin.dashboard', compact('statistics', 'userStats', 'dailySales', 'recentBusinesses', 'calendarEvents'));
    }

    /**
     * Get dashboard statistics for AJAX requests.
     */
    public function getStatistics()
    {
        $statistics = [
            'categories' => Category::count(),
            'headlines' => Headline::count(),
            'posts' => Post::count(),
            'data' => Data::count(),
            'documents' => Document::count(),
            'files' => File::count(),
            'businesses' => Business::count(),
            'icons' => Icon::count(),
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

    /**
     * Get calendar events data.
     */
    private function getCalendarEventsData()
    {
        // Sample events - you can replace this with dynamic data from database
        return [
            [
                'title' => 'Meeting Tim',
                'start' => '2025-08-11',
                'backgroundColor' => '#007bff',
                'borderColor' => '#007bff',
                'description' => 'Meeting rutin dengan tim development'
            ],
            [
                'title' => 'Review UMKM',
                'start' => '2025-08-15',
                'backgroundColor' => '#28a745',
                'borderColor' => '#28a745',
                'description' => 'Review aplikasi UMKM yang masuk'
            ],
            [
                'title' => 'Deadline Report',
                'start' => '2025-08-20',
                'backgroundColor' => '#dc3545',
                'borderColor' => '#dc3545',
                'description' => 'Deadline pengumpulan laporan bulanan'
            ],
            [
                'title' => 'Training',
                'start' => '2025-08-25',
                'backgroundColor' => '#ffc107',
                'borderColor' => '#ffc107',
                'textColor' => '#000',
                'description' => 'Training penggunaan sistem baru'
            ],
            [
                'title' => 'Evaluasi Sistem',
                'start' => '2025-08-30',
                'backgroundColor' => '#6f42c1',
                'borderColor' => '#6f42c1',
                'description' => 'Evaluasi kinerja sistem portal'
            ]
        ];
    }

    /**
     * Get calendar events for AJAX requests.
     */
    public function getCalendarEvents()
    {
        $events = $this->getCalendarEventsData();
        return response()->json($events);
    }
}
