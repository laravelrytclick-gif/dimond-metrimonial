@csrf

@if(isset($role))
    @method('PUT')
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Role Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $role->name ?? '') }}" 
                           required
                           autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        Use lowercase letters, numbers, and hyphens only (e.g., 'content-manager')
                    </small>
                </div>

                <div class="mb-3">
                    <label for="guard_name" class="form-label">Guard Name</label>
                    <select class="form-select @error('guard_name') is-invalid @enderror" 
                            id="guard_name" 
                            name="guard_name">
                        <option value="web" {{ (old('guard_name', $role->guard_name ?? '') === 'web') ? 'selected' : '' }}>
                            Web (Default)
                        </option>
                        <option value="api" {{ (old('guard_name', $role->guard_name ?? '') === 'api') ? 'selected' : '' }}>
                            API
                        </option>
                    </select>
                    @error('guard_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Permissions</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAllPermissions">
                    <label class="form-check-label" for="selectAllPermissions">
                        Select All
                    </label>
                </div>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @error('permissions')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="row">
                    @php
                        $groupedPermissions = $permissions->groupBy(function($item) {
                            return explode(' ', $item->name)[0] ?? 'other';
                        });
                    @endphp

                    @foreach($groupedPermissions as $group => $groupPermissions)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ ucfirst($group) }}</h6>
                                </div>
                                <div class="card-body">
                                    @foreach($groupPermissions as $permission)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input permission-checkbox" 
                                                   type="checkbox" 
                                                   name="permissions[]" 
                                                   value="{{ $permission->name }}"
                                                   id="permission_{{ $permission->id }}"
                                                   {{ in_array($permission->name, old('permissions', $role->permissions->pluck('name')->toArray() ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select All Permissions
        const selectAll = document.getElementById('selectAllPermissions');
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        });

        // If any checkbox is unchecked, uncheck "Select All"
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAll.checked = false;
                } else {
                    // Check if all checkboxes are checked
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    selectAll.checked = allChecked;
                }
            });
        });

        // Check "Select All" if all checkboxes are checked on page load
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        selectAll.checked = allChecked && checkboxes.length > 0;
    });
</script>
@endpush