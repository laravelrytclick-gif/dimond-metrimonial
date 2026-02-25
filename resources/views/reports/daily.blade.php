@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Daily Report') }} - {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</span>
                    <div>
                        <a href="{{ route('reports.daily.export', ['date' => $date, 'rm_id' => $selectedRM]) }}" class="btn btn-success btn-sm me-2">
                            <i class="fas fa-download"></i> {{ __('Export CSV') }}
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filters -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('reports.daily') }}">
                                <div class="input-group">
                                    <input type="date" name="date" class="form-control" value="{{ $date }}" max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-filter"></i> {{ __('Filter') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('reports.daily') }}">
                                <input type="hidden" name="date" value="{{ $date }}">
                                <select name="rm_id" class="form-select" onchange="this.form.submit()">
                                    <option value="all" {{ $selectedRM === 'all' ? 'selected' : '' }}>
                                        {{ __('All RMs') }}
                                    </option>
                                    @foreach($rms as $rm)
                                        <option value="{{ $rm->id }}" {{ $selectedRM == $rm->id ? 'selected' : '' }}>
                                            {{ $rm->name }} ({{ $rm->managedProfiles->count() }} profiles)
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Total Profiles Created') }}</h5>
                                    <h3>{{ $summary['total_profiles_created'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Total Meetings') }}</h5>
                                    <h3>{{ $summary['total_meetings'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Total Calls') }}</h5>
                                    <h3>{{ $summary['total_calls'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Total Revenue') }}</h5>
                                    <h3>₹{{ number_format($summary['total_revenue'], 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RM Performance Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>{{ __('RM Name') }}</th>
                                    <th>{{ __('Total Profiles') }}</th>
                                    <th>{{ __('Created Today') }}</th>
                                    <th>{{ __('Updated Today') }}</th>
                                    <th>{{ __('Status Changes') }}</th>
                                    <th>{{ __('Meetings') }}</th>
                                    <th>{{ __('Calls') }}</th>
                                    <th>{{ __('Payments') }}</th>
                                    <th>{{ __('Revenue') }}</th>
                                    <th>{{ __('Performance') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rmMetrics as $metrics)
                                    <tr>
                                        <td>
                                            <strong>{{ $metrics['rm']->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $metrics['rm']->email }}</small>
                                        </td>
                                        <td>{{ $metrics['total_profiles'] }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $metrics['profiles_created_today'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $metrics['profiles_updated_today'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $metrics['status_changes_today'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $metrics['meetings_today'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $metrics['calls_today'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $metrics['payments_today'] }}</span>
                                        </td>
                                        <td>
                                            <strong>₹{{ number_format($metrics['total_revenue_today'], 2) }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                $activityScore = $metrics['meetings_today'] * 3 + 
                                                                 $metrics['calls_today'] * 2 + 
                                                                 $metrics['status_changes_today'] * 1 +
                                                                 ($metrics['total_revenue_today'] > 0 ? 5 : 0);
                                                
                                                if ($activityScore >= 10) {
                                                    $badgeClass = 'bg-success';
                                                    $performance = 'Excellent';
                                                } elseif ($activityScore >= 5) {
                                                    $badgeClass = 'bg-warning';
                                                    $performance = 'Good';
                                                } else {
                                                    $badgeClass = 'bg-danger';
                                                    $performance = 'Low';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $performance }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            {{ __('No data found for the selected criteria') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Additional Summary Stats -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>{{ __('Summary Statistics') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>{{ __('Active RMs') }}:</strong> {{ $summary['total_rms'] }}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>{{ __('Total Status Changes') }}:</strong> {{ $summary['total_status_changes'] }}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>{{ __('Total Payments') }}:</strong> {{ $summary['total_payments'] }}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>{{ __('Average Revenue per RM') }}:</strong> 
                                            ₹{{ number_format($summary['total_rms'] > 0 ? $summary['total_revenue'] / $summary['total_rms'] : 0, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
