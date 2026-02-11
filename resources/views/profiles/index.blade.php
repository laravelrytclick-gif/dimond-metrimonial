@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Profiles') }}</span>
                    @can('create', App\Models\Profile::class)
                        <a href="{{ route('profiles.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> {{ __('Add New Profile') }}
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('User Code') }}</th>
                                    <th>{{ __('Full Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('RM') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($profiles as $profile)
                                    <tr>
                                        <td>{{ $profile->user_code }}</td>
                                        <td>{{ $profile->full_name }}</td>
                                        <td>{{ $profile->email }}</td>
                                        <td>{{ $profile->phone }}</td>
                                        <td>
                                            @if($profile->relationshipManager)
                                                {{ $profile->relationshipManager->name }}
                                            @else
                                                {{ __('Not Assigned') }}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $profile->status === 'Active' ? 'success' : ($profile->status === 'Inactive' ? 'danger' : 'warning') }}">
                                                {{ $profile->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('profiles.show', $profile) }}" class="btn btn-sm btn-info" title="{{ __('View') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @can('update', $profile)
                                                    <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-sm btn-primary" title="{{ __('Edit') }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete', $profile)
                                                    <form action="{{ route('profiles.destroy', $profile) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ __('Delete') }}" onclick="return confirm('{{ __('Are you sure you want to delete this profile?') }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('No profiles found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $profiles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
