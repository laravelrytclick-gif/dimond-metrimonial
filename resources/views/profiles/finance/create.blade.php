@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Record New Payment - {{ $profile->full_name }}
                </div>

                <div class="card-body">
                    <form action="{{ route('profiles.finance.store', $profile) }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="package_name" class="form-label">Package <span class="text-danger">*</span></label>
                                <select class="form-select @error('package_name') is-invalid @enderror" 
                                        id="package_name" 
                                        name="package_name" 
                                        required>
                                    <option value="">Select Package</option>
                                    @foreach($packageOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('package_name') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('package_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="amount_paid" class="form-label">Amount Paid (₹) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       class="form-control @error('amount_paid') is-invalid @enderror" 
                                       id="amount_paid" 
                                       name="amount_paid" 
                                       value="{{ old('amount_paid') }}"
                                       required>
                                @error('amount_paid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('payment_date') is-invalid @enderror" 
                                       id="payment_date" 
                                       name="payment_date" 
                                       value="{{ old('payment_date', now()->format('Y-m-d')) }}"
                                       required>
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="payment_mode" class="form-label">Payment Mode <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_mode') is-invalid @enderror" 
                                        id="payment_mode" 
                                        name="payment_mode" 
                                        required>
                                    <option value="">Select Payment Mode</option>
                                    @foreach($paymentModes as $value => $label)
                                        <option value="{{ $value }}" {{ old('payment_mode') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_mode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="expiry_date" class="form-label">Expiry Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('expiry_date') is-invalid @enderror" 
                                       id="expiry_date" 
                                       name="expiry_date" 
                                       value="{{ old('expiry_date') }}"
                                       required>
                                @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" 
                                      name="remarks" 
                                      rows="3">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profiles.finance.index', $profile) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set default expiry date to 1 year from now if not set
        const expiryDate = document.getElementById('expiry_date');
        if (expiryDate && !expiryDate.value) {
            const today = new Date();
            const nextYear = new Date(today.getFullYear() + 1, today.getMonth(), today.getDate());
            expiryDate.valueAsDate = nextYear;
        }
    });
</script>
@endpush
@endsection