<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Ticket;
use DB;

class DashboardController extends Controller
{


    public function index()
    {
        $connections = ['technical', 'billing', 'product', 'feedback', 'general'];

        $totalTickets = 0;
        $openTickets = 0;
        $closedTickets = 0;
        $pendingTickets = 0;

        $weekData = [];
        $monthData = [];
        $yearData = [];
        $allData = [];

        foreach ($connections as $conn) {
            $totalTickets += Ticket::on($conn)->count();
            $openTickets += Ticket::on($conn)->where('status', 'open')->count();
            $closedTickets += Ticket::on($conn)->where('status', 'closed')->count();
            $pendingTickets += Ticket::on($conn)->where('status', 'pending')->count();

            // Last 7 days
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i)->toDateString();
                $weekData[$date] = ($weekData[$date] ?? 0) + Ticket::on($conn)->whereDate('created_at', $date)->count();
            }

            // Last 4 weeks
            for ($i = 3; $i >= 0; $i--) {
                $start = Carbon::now()->startOfWeek()->subWeeks($i);
                $end = $start->copy()->endOfWeek();
                $label = 'Week ' . $start->format('W');
                $monthData[$label] = ($monthData[$label] ?? 0) + Ticket::on($conn)->whereBetween('created_at', [$start, $end])->count();
            }

            // Last 12 months
            for ($i = 11; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i)->format('Y-m');
                $yearData[$month] = ($yearData[$month] ?? 0) + Ticket::on($conn)->whereYear('created_at', Carbon::now()->subMonths($i)->year)
                    ->whereMonth('created_at', Carbon::now()->subMonths($i)->month)->count();
            }
        }

        $chartData = [
            'week' => array_values($weekData),
            'week_labels' => array_keys($weekData),

            'month' => array_values($monthData),
            'month_labels' => array_keys($monthData),

            'year' => array_values($yearData),
            'year_labels' => array_keys($yearData),

            'all' => [$totalTickets], // or average
            'all_labels' => ['Total']
        ];

        return view('admin.dashboard', compact(
            'totalTickets',
            'openTickets',
            'closedTickets',
            'pendingTickets',
            'chartData'
        ));
    }
}
