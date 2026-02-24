@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Create New Permission</h4>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Permissions
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.permissions.store') }}" method="POST">
                        @include('admin.permissions._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
