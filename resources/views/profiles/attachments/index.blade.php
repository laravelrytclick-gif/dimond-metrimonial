@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Attachments - {{ $profile->full_name }}</span>
                    <div>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="fas fa-upload"></i> Upload Files
                        </button>
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

                    @foreach(['photo' => 'Photos', 'biodata' => 'Biodata', 'id' => 'ID Proofs'] as $category => $label)
                        <div class="mb-5">
                            <h5 class="border-bottom pb-2 mb-3">{{ $label }}</h5>
                            
                            @if(isset($attachments[$category]) && $attachments[$category]->count())
                                <div class="row g-3">
                                    @foreach($attachments[$category] as $attachment)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="card h-100">
                                                @if($category === 'photo')
                                                    <img src="{{ Storage::url($attachment->file_path) }}" 
                                                         class="card-img-top" 
                                                         alt="{{ $attachment->file_name }}"
                                                         style="height: 150px; object-fit: cover;">
                                                @else
                                                    <div class="text-center py-4">
                                                        <i class="fas fa-{{ $attachment->getFileIcon() }} fa-4x text-muted"></i>
                                                    </div>
                                                @endif
                                                <div class="card-body">
                                                    <h6 class="card-title text-truncate" title="{{ $attachment->file_name }}">
                                                        {{ $attachment->file_name }}
                                                    </h6>
                                                    <p class="card-text small text-muted mb-1">
                                                        {{ $attachment->meta['description'] ?? 'No description' }}
                                                    </p>
                                                    <p class="card-text small text-muted mb-2">
                                                        {{ number_format($attachment->meta['size'] / 1024, 1) }} KB
                                                    </p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <a href="{{ route('profiles.attachments.show', [$profile, $attachment]) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <form action="{{ route('profiles.attachments.destroy', [$profile, $attachment]) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Delete this file?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-muted small">
                                                    Uploaded {{ $attachment->created_at->diffForHumans() }}
                                                    by {{ $attachment->uploadedBy->name }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    No {{ strtolower($label) }} found.
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('profiles.attachments.store', $profile) }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Upload Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select" id="category" name="category" required>
                            @foreach(App\Models\ProfileAttachment::getCategories() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="attachments" class="form-label">Files <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="attachments" name="attachments[]" multiple required>
                        <div class="form-text">Max file size: 10MB. Allowed types: images, documents, PDFs.</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <input type="text" class="form-control" id="description" name="description" 
                               placeholder="Brief description of the files">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection