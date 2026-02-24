@extends('layouts.app')

@section('title', 'Create New Role')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Create New Role</h4>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Roles
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.roles.store') }}" method="POST" id="roleForm">
                        @include('admin.roles._form')
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection