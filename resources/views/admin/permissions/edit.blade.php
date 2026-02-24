@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Edit Permission: {{ $permission->name }}</h4>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Permissions
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.permissions._form')
                    </form>

                    <hr class="my-4">
                    
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Danger Zone</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Deleting a permission will remove it from all roles. This action cannot be undone.
                                @if($permission->roles->count() > 0)
                                    <br>
                                    <strong>Warning:</strong> This permission is currently assigned to {{ $permission->roles->count() }} role(s).
                                @endif
                            </p>
                            @can('delete', $permission)
                                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="d-inline" 
                                    onsubmit="return confirm('Are you sure you want to delete this permission? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Delete Permission
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
