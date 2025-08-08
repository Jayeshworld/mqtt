<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with('elevators');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('sort')) {
            $query->orderBy($request->sort, $request->input('direction', 'asc'));
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $users = $query->paginate(10);

        return view('users.list', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'mobile'          => 'nullable|string|max:20',
            'role'            => ['required', Rule::in(['admin', 'manager', 'user'])],
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'address'         => 'nullable|string|max:500',
            'city'            => 'nullable|string|max:100',
            'state'           => 'nullable|string|max:100',
            'zip'             => 'nullable|string|max:20',
            'country'         => 'nullable|string|max:100',
            'password'        => 'required|string|min:8|confirmed',
        ]);

        // File upload
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        // Password hash
        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now(); // Set email verified at to now

        // Create user
        $user = User::create($validated);

        // Optionally send welcome email
        if ($request->has('send_welcome_email')) {
            // dispatch email job here
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Validation
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => ['required','email', Rule::unique('users')->ignore($user->id)],
            'mobile'          => 'nullable|string|max:20',
            'role'            => ['required', Rule::in(['admin', 'manager', 'user'])],
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'address'         => 'nullable|string|max:500',
            'city'            => 'nullable|string|max:100',
            'state'           => 'nullable|string|max:100',
            'zip'             => 'nullable|string|max:20',
            'country'         => 'nullable|string|max:100',
            'password'        => 'nullable|string|min:8|confirmed',
        ]);

        // File upload
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        // Update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        // Update user
        $validated['email_verified_at'] = now(); // Update email verified at to now

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function show(User $user)
    {
        $user->load('elevators');
        return view('users.view', compact('user'));
    }
}
