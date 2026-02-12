@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ $profile->full_name }}'s Background Information</span>
                    <div>
                        <a href="{{ route('profiles.show', $profile) }}" class="btn btn-sm btn-secondary me-2">
                            <i class="fas fa-arrow-left"></i> Back to Profile
                        </a>
                        <a href="{{ route('profiles.backgrounds.create', $profile) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Add Background
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5>Education</h5>
                        @php
                            $education = $backgrounds->where('type', 'education')->sortByDesc('year_from');
                        @endphp
                        
                        @if($education->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Degree/Qualification</th>
                                            <th>Institution</th>
                                            <th>Specialization</th>
                                            <th>Duration</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($education as $edu)
                                            <tr>
                                                <td>{{ $edu->title }}</td>
                                                <td>{{ $edu->organization }}</td>
                                                <td>{{ $edu->specialization ?? 'N/A' }}</td>
                                                <td>{{ $edu->duration }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('profiles.backgrounds.edit', ['profile' => $profile, 'background' => $edu]) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('profiles.backgrounds.destroy', ['profile' => $profile, 'background' => $edu]) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                                    onclick="return confirm('Are you sure you want to delete this?')">
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
                        @else
                            <div class="alert alert-info">No education information added yet.</div>
                        @endif
                    </div>

                    <div class="mt-5">
                        <h5>Professional Experience</h5>
                        @php
                            $experience = $backgrounds->where('type', 'profession')->sortByDesc('year_from');
                        @endphp
                        
                        @if($experience->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Designation</th>
                                            <th>Organization</th>
                                            <th>Specialization</th>
                                            <th>Duration</th>
                                            <th>Income</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($experience as $exp)
                                            <tr>
                                                <td>{{ $exp->title }}</td>
                                                <td>{{ $exp->organization }}</td>
                                                <td>{{ $exp->specialization ?? 'N/A' }}</td>
                                                <td>{{ $exp->duration }}</td>
                                                <td>{{ $exp->income ?? 'N/A' }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('profiles.backgrounds.edit', ['profile' => $profile, 'background' => $exp]) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('profiles.backgrounds.destroy', ['profile' => $profile, 'background' => $exp]) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                                    onclick="return confirm('Are you sure you want to delete this?')">
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
                        @else
                            <div class="alert alert-info">No professional experience added yet.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection