<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dailyReport(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $selectedRM = $request->get('rm_id', 'all');

        // Get all RMs
        $rms = User::role('rm')->with('managedProfiles')->get();

        // Build query
        $query = Profile::with(['relationshipManager', 'statusHistories', 'meetings', 'callFollowups', 'finances'])
            ->when($selectedRM !== 'all', function($q) use ($selectedRM) {
                return $q->where('rm_id', $selectedRM);
            });

        // Get profiles created on the selected date
        $profilesCreated = $query->whereDate('created_at', $date)->get();

        // Get profiles with activities on the selected date
        $profilesUpdated = Profile::with(['relationshipManager', 'statusHistories', 'meetings', 'callFollowups'])
            ->when($selectedRM !== 'all', function($q) use ($selectedRM) {
                return $q->where('rm_id', $selectedRM);
            })
            ->where(function($q) use ($date) {
                $q->whereHas('statusHistories', function($subQ) use ($date) {
                    $subQ->whereDate('changed_at', $date);
                })
                ->orWhereHas('meetings', function($subQ) use ($date) {
                    $subQ->whereDate('meeting_date', $date);
                })
                ->orWhereHas('callFollowups', function($subQ) use ($date) {
                    $subQ->whereDate('followup_date', $date);
                })
                ->orWhereHas('finances', function($subQ) use ($date) {
                    $subQ->whereDate('payment_date', $date);
                });
            })
            ->get();

        // Calculate metrics for each RM
        $rmMetrics = [];
        foreach ($rms as $rm) {
            $rmProfilesCreated = $profilesCreated->where('rm_id', $rm->id);
            $rmProfilesUpdated = $profilesUpdated->where('rm_id', $rm->id);

            $metrics = [
                'rm' => $rm,
                'total_profiles' => $rm->managedProfiles->count(),
                'profiles_created_today' => $rmProfilesCreated->count(),
                'profiles_updated_today' => $rmProfilesUpdated->count(),
                'status_changes_today' => 0,
                'meetings_today' => 0,
                'calls_today' => 0,
                'payments_today' => 0,
                'total_revenue_today' => 0,
            ];

            // Count activities for this RM
            foreach ($rmProfilesUpdated as $profile) {
                $metrics['status_changes_today'] += $profile->statusHistories->whereDate('changed_at', $date)->count();
                $metrics['meetings_today'] += $profile->meetings->whereDate('meeting_date', $date)->count();
                $metrics['calls_today'] += $profile->callFollowups->whereDate('followup_date', $date)->count();
                
                foreach ($profile->finances->whereDate('payment_date', $date) as $finance) {
                    $metrics['payments_today']++;
                    $metrics['total_revenue_today'] += $finance->amount ?? 0;
                }
            }

            $rmMetrics[] = $metrics;
        }

        // Overall summary
        $summary = [
            'total_rms' => $rms->count(),
            'total_profiles_created' => $profilesCreated->count(),
            'total_profiles_updated' => $profilesUpdated->count(),
            'total_status_changes' => collect($rmMetrics)->sum('status_changes_today'),
            'total_meetings' => collect($rmMetrics)->sum('meetings_today'),
            'total_calls' => collect($rmMetrics)->sum('calls_today'),
            'total_payments' => collect($rmMetrics)->sum('payments_today'),
            'total_revenue' => collect($rmMetrics)->sum('total_revenue_today'),
        ];

        return view('reports.daily', compact('rmMetrics', 'summary', 'rms', 'date', 'selectedRM'));
    }

    public function exportDailyReport(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $selectedRM = $request->get('rm_id', 'all');

        // Get the same data as the report
        $rms = User::role('rm')->with('managedProfiles')->get();
        
        $query = Profile::with(['relationshipManager', 'statusHistories', 'meetings', 'callFollowups', 'finances'])
            ->when($selectedRM !== 'all', function($q) use ($selectedRM) {
                return $q->where('rm_id', $selectedRM);
            });

        $profilesCreated = $query->whereDate('created_at', $date)->get();
        $profilesUpdated = Profile::with(['relationshipManager', 'statusHistories', 'meetings', 'callFollowups', 'finances'])
            ->when($selectedRM !== 'all', function($q) use ($selectedRM) {
                return $q->where('rm_id', $selectedRM);
            })
            ->where(function($q) use ($date) {
                $q->whereHas('statusHistories', function($subQ) use ($date) {
                    $subQ->whereDate('changed_at', $date);
                })
                ->orWhereHas('meetings', function($subQ) use ($date) {
                    $subQ->whereDate('meeting_date', $date);
                })
                ->orWhereHas('callFollowups', function($subQ) use ($date) {
                    $subQ->whereDate('followup_date', $date);
                })
                ->orWhereHas('finances', function($subQ) use ($date) {
                    $subQ->whereDate('payment_date', $date);
                });
            })
            ->get();

        // Build CSV data
        $headers = [
            'RM Name',
            'RM Email',
            'Total Profiles',
            'Profiles Created Today',
            'Profiles Updated Today',
            'Status Changes Today',
            'Meetings Today',
            'Calls Today',
            'Payments Today',
            'Revenue Today',
        ];

        $rows = [];
        foreach ($rms as $rm) {
            $rmProfilesCreated = $profilesCreated->where('rm_id', $rm->id);
            $rmProfilesUpdated = $profilesUpdated->where('rm_id', $rm->id);

            $statusChanges = 0;
            $meetings = 0;
            $calls = 0;
            $payments = 0;
            $revenue = 0;

            foreach ($rmProfilesUpdated as $profile) {
                $statusChanges += $profile->statusHistories->whereDate('changed_at', $date)->count();
                $meetings += $profile->meetings->whereDate('meeting_date', $date)->count();
                $calls += $profile->callFollowups->whereDate('followup_date', $date)->count();
                
                foreach ($profile->finances->whereDate('payment_date', $date) as $finance) {
                    $payments++;
                    $revenue += $finance->amount ?? 0;
                }
            }

            $rows[] = [
                $rm->name,
                $rm->email,
                $rm->managedProfiles->count(),
                $rmProfilesCreated->count(),
                $rmProfilesUpdated->count(),
                $statusChanges,
                $meetings,
                $calls,
                $payments,
                number_format($revenue, 2),
            ];
        }

        $filename = "daily_report_{$date}.csv";
        
        $callback = function() use ($headers, $rows) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
