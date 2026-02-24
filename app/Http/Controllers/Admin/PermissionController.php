<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Permission::class);
        $permissions = Permission::with('roles')->latest()->paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $this->authorize('create', Permission::class);
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);
        
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->where(function ($query) use ($request) {
                    return $query->where('name', $request->name);
                })
            ],
            'description' => 'nullable|string|max:255',
        ]);

        $permission = Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission created successfully');
    }

    public function edit(Permission $permission)
    {
        $this->authorize('update', $permission);
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $this->authorize('update', $permission);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($permission->id)
            ],
            'description' => 'nullable|string|max:255',
        ]);

        $permission->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);
        
        // Prevent deletion of permissions that are in use
        if ($permission->roles()->count() > 0) {
            return back()->with('error', 'Cannot delete permission: it is assigned to one or more roles.');
        }

        $permission->delete();
        
        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully');
    }
}