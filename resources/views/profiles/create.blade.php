@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Create New Profile') }}
                </div>

                <div class="card-body">
                    <form action="{{ route('profiles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('profiles._form')
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save Profile') }}
                                </button>
                                <a href="{{ route('profiles.index') }}" class="btn btn-secondary">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
