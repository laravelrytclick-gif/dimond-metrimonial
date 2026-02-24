<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
public function index()
{
    $roles = Role::with('permissions')->paginate(10);
    return view('admin.roles.index', compact('roles'));
}


public function create()
{
    $permissions = Permission::all();
    return view('admin.roles.create', compact('permissions'));
}

// public function edit(Role $role)
// {
//     $permissions = Permission::all();
//     return view('admin.roles.edit', compact('role', 'permissions'));
// }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null
        ]);

        $role->permissions()->sync($validated['permissions']);

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role)
{
    $permissions = Permission::all();
    $roles = Role::with('permissions')->get(); // add this

    return view('admin.roles.edit', compact('role', 'permissions', 'roles'));
}


    // public function edit(Role $role)
    // {
    //     if ($role->name === 'admin') {
    //         return redirect()->route('roles.index')->with('error', 'Cannot edit admin role');
    //     }

    //     $permissions = Permission::all();
    //     return view('roles.edit', compact('role', 'permissions'));
    // }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()->route('roles.index')->with('error', 'Cannot update admin role');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null
        ]);

        $role->permissions()->sync($validated['permissions']);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()->back()->with('error', 'Cannot delete admin role');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}