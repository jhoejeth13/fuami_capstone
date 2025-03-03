<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Only allow users with the 'view-user' permission to access this page
        $this->authorize('view-user');

        // Fetch users with pagination (optional)
        $users = User::paginate(10); // Adjust the number of items per page as needed
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Only allow users with the 'create-user' permission to access this page
        $this->authorize('create-user');

        // Fetch all roles and permissions for the form
        $roles = Role::all();
        $permissions = Permission::all();

        return view('users.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Only allow users with the 'create-user' permission to access this page
        $this->authorize('create-user');

        // Validate the request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'], // Validate the role
            'permissions' => ['nullable', 'array'], // Validate permissions
            'permissions.*' => ['exists:permissions,name'], // Validate each permission
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign the selected role to the user
        $user->assignRole($request->role);

        // Assign permissions to the user
        if ($request->has('permissions')) {
            $user->givePermissionTo($request->permissions);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Only allow users with the 'edit-user' permission to access this page
        $this->authorize('edit-user');

        // Fetch all roles and permissions for the form
        $roles = Role::all();
        $permissions = Permission::all();

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Only allow users with the 'edit-user' permission to access this page
        $this->authorize('edit-user');

        // Validate the request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'], // Validate the role
            'permissions' => ['nullable', 'array'], // Validate permissions
            'permissions.*' => ['exists:permissions,name'], // Validate each permission
        ]);

        // Update the user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Sync the user's role
        $user->syncRoles($request->role);

        // Sync the user's permissions
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Only allow users with the 'delete-user' permission to access this page
        $this->authorize('delete-user');

        // Delete the user
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}