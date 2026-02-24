@csrf

<div class="mb-3">
    <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
    <input type="text" 
           class="form-control @error('name') is-invalid @enderror" 
           id="name" 
           name="name" 
           value="{{ old('name', $permission->name ?? '') }}" 
           required>
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
    <div class="form-text">
        Use lowercase with dot notation (e.g., 'users.create', 'roles.edit').
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" 
              id="description" 
              name="description" 
              rows="2">{{ old('description', $permission->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Permissions
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> {{ isset($permission) ? 'Update' : 'Create' }} Permission
    </button>
</div>
