@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h1>Permissions Management</h1>
        </div>
        <div class="col text-end">
            @can('create', \App\Models\Permission::class)
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Create Permission
                </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Assigned to Roles</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td><code>{{ $permission->name }}</code></td>
                                <td>{{ $permission->description ?? 'N/A' }}</td>
                                <td>
                                    @if($permission->roles->count() > 0)
                                        @foreach($permission->roles->take(3) as $role)
                                            <span class="badge bg-primary">{{ $role->name }}</span>
                                        @endforeach
                                        @if($permission->roles->count() > 3)
                                            <span class="badge bg-secondary">+{{ $permission->roles->count() - 3 }} more</span>
                                        @endif
                                    @else
                                        <span class="text-muted">No roles</span>
                                    @endif
                                </td>
                                <td>{{ $permission->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('update', $permission)
                                            <a href="{{ route('admin.permissions.edit', $permission) }}" 
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit Permission">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('delete', $permission)
                                            <form action="{{ route('admin.permissions.destroy', $permission) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this permission? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Permission">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No permissions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($permissions->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $permissions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
