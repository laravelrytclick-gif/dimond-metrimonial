@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <h4>Welcome to Testimonial CRM</h4>
                <p>You are logged in as {{ Auth::user()->name }} ({{ Auth::user()->roles->first()->name }})</p>
                
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Users</h5>
                                <p class="card-text">{{ \App\Models\User::count() }} users registered</p>
                                @can('manage users')
                                    <a href="{{ route('users.index') }}" class="btn btn-light">Manage Users</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Roles</h5>
                                <p class="card-text">{{ \App\Models\Role::count() }} roles defined</p>
                                @can('manage roles')
                                    <a href="{{ route('roles.index') }}" class="btn btn-light">Manage Roles</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Testimonials</h5>
                                <p class="card-text">{{ \App\Models\Testimonial::count() }} testimonials</p>
                                <a href="{{ route('testimonials.index') }}" class="btn btn-light">View Testimonials</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection