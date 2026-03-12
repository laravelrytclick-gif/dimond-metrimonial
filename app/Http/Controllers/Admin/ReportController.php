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

    public function todayWorkHistory(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $selectedRM = $request->get('rm_id', 'all');

        // Get all RMs
        $rms = User::role('rm')->with('managedProfiles')->get();

        // Get all activities for the selected date
        $activities = collect();

        // Profile status changes
        $statusChanges = DB::table('profile_status_histories')
            ->join('profiles', 'profile_status_histories.profile_id', '=', 'profiles.id')
            ->join('users', 'profiles.rm_id', '=', 'users.id')
            ->select([
                'profile_status_histories.id',
                'profile_status_histories.profile_id',
                'profiles.full_name as profile_name',
                'users.name as rm_name',
                DB::raw("'Status Change' as activity_type"),
                DB::raw("'profile_status_histories' as source_table"),
                'profile_status_histories.changed_at',
                DB::raw("NULL as comments"),
                DB::raw("NULL as amount"),
                DB::raw("NULL as payment_type")
            ])
            ->when($selectedRM !== 'all', function($q) use ($selectedRM) {
                return $q->where('profiles.rm_id', $selectedRM);
            })
            ->whereDate('profile_status_histories.changed_at', $date);

        // Meetings
        $meetings = DB::table('profile_meetings')
            ->join('profiles', 'profile_meetings.profile_id', '=', 'profiles.id')
            ->join('users', 'profiles.rm_id', '=', 'users.id')
            ->select([
                'profile_meetings.id',
                'profile_meetings.profile_id',
                'profiles.full_name as profile_name',
                'users.name as rm_name',
                DB::raw("'Meeting' as activity_type"),
                DB::raw("'profile_meetings' as source_table"),
                'profile_meetings.meeting_date as changed_at',
                'profile_meetings.notes as comments',
                DB::raw("NULL as amount"),
                DB::raw("NULL as payment_type")
            ])
            ->when($selectedRM !== 'all', function($q) use ($selectedRM) {
                return $q->where('profiles.rm_id', $selectedRM);
            })
            ->whereDate('profile_meetings.meeting_date', $date);

        // Call followups
        $calls = DB::table('profile_call_followups')
            ->join('profiles', 'profile_call_followups.profile_id', '=', 'profiles.id')
            ->join('users', 'profiles.rm_id', '=', 'users.id')
            ->select([
                'profile_call_followups.id',
                'profile_call_followups.profile_id',
                'profiles.full_name as profile_name',
                'users.name as rm_name',
                DB::raw("'Call Followup' as activity_type"),
                DB::raw("'profile_call_followups' as source_table"),
                'profile_call_followups.followup_date as changed_at',
                'profile_call_followups.notes as comments',
                DB::raw("NULL as amount"),
                DB::raw("NULL as payment_type")
            ])
            ->when($selectedRM !== 'all', function($q) use ($selectedRM) {
                return $q->where('profiles.rm_id', $selectedRM);
            })
            ->whereDate('profile_call_followups.followup_date', $date);

        // Payments
        $payments = DB::table('profile_finances')
            ->join('profiles', 'profile_finances.profile_id', '=', 'profiles.id')
            ->join('users', 'profiles.rm_id', '=', 'users.id')
            ->select([
                'profile_finances.id',
                'profile_finances.profile_id',
                'profiles.full_name as profile_name',
                'users.name as rm_name',
                DB::raw("'Payment' as activity_type"),
                DB::raw("'profile_finances' as source_table"),
                'profile_finances.payment_date as changed_at',
                DB::raw("CONCAT('Amount: ', amount_paid, ', Type: ', payment_mode) as comments"),
                'profile_finances.amount_paid as amount',
                'profile_finances.payment_mode as payment_type'
            ])
            ->when($selectedRM !== 'all', function($q) use ($selectedRM) {
                return $q->where('profiles.rm_id', $selectedRM);
            })
            ->whereDate('profile_finances.payment_date', $date);

        // Combine all activities
        $allActivities = $statusChanges->union($meetings)->union($calls)->union($payments);

        $allActivities = $allActivities->orderBy('changed_at', 'desc')->get();

        return view('reports.today-work', compact('allActivities', 'rms', 'date', 'selectedRM'));
    }
}
