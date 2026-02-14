@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <span>Financial Records - {{ $profile->full_name }}</span>
                        @if($profile->activeSubscription)
                            <span class="badge bg-success ms-2">
                                Active until {{ $profile->activeSubscription->expiry_date->format('M d, Y') }}
                            </span>
                        @else
                            <span class="badge bg-warning ms-2">No Active Subscription</span>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('profiles.finance.create', $profile) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Add Payment
                        </a>
                        <a href="{{ route('profiles.show', $profile) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Profile
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="text-muted">Total Payments</h6>
                                    <h4>₹{{ number_format($totalPaid, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="text-muted">Active Subscription</h6>
                                    <h4>
                                        @if($profile->activeSubscription)
                                            {{ $profile->activeSubscription->package_name }}
                                        @else
                                            None
                                        @endif
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="text-muted">Expiry Date</h6>
                                    <h4>
                                        @if($profile->activeSubscription)
                                            {{ $profile->activeSubscription->expiry_date->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($transactions->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Package</th>
                                        <th>Amount</th>
                                        <th>Payment Mode</th>
                                        <th>Expiry Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr class="{{ $transaction->expiry_date->isFuture() ? 'table-success' : '' }}">
                                            <td>{{ $transaction->payment_date->format('M d, Y') }}</td>
                                            <td>{{ $transaction->package_name }}</td>
                                            <td>₹{{ number_format($transaction->amount_paid, 2) }}</td>
                                            <td>{{ $transaction->payment_mode }}</td>
                                            <td>
                                                <span class="{{ $transaction->expiry_date->isPast() ? 'text-danger' : '' }}">
                                                    {{ $transaction->expiry_date->format('M d, Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('profiles.finance.show', [$profile, $transaction]) }}" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('profiles.finance.edit', [$profile, $transaction]) }}" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('profiles.finance.destroy', [$profile, $transaction]) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Delete this payment record?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            No payment records found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection