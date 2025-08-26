<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        // ensure auth for these routes
        $this->middleware('auth')->except(['show']); // show may be public if needed
    }

    // Admin: list all users
    public function index()
    {
        $this->authorizeAdmin();
        $users = User::orderByDesc('created_at')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorizeAdmin();

        $data = $request->validated();
        // generate activation token if want (admin-created could be auto-active)
        $data['activation_token'] = \Illuminate\Support\Str::random(64);
        $data['user_status'] = $request->input('user_status', 'inactive');
        $user = User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully. Activation link: ' . route('activate', $user->activation_token));
    }

    public function show($id)
    {
        $user = User::where('user_id', $id)->firstOrFail();
        // if authenticated user and not admin, ensure they view only own profile
        if (Auth::check() && !Auth::user()->isAdmin()) {
            if (Auth::id() !== $user->user_id) {
                abort(403, 'Unauthorized to view this profile.');
            }
        }
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::where('user_id', $id)->firstOrFail();

        // admin can edit any user, non-admin only their own
        if (!Auth::user()->isAdmin() && Auth::id() !== $user->user_id) {
            abort(403);
        }

        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::where('user_id', $id)->firstOrFail();

        if (!Auth::user()->isAdmin() && Auth::id() !== $user->user_id) {
            abort(403);
        }

        $data = $request->validated();

        // if password nullable
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        $user = User::where('user_id', $id)->firstOrFail();
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $this->authorizeAdmin();
        $user = User::where('user_id', $id)->firstOrFail();
        if ($user->user_status === 'blocked') {
            $user->user_status = 'active';
        } else {
            $user->user_status = 'blocked';
        }
        $user->save();
        return redirect()->back()->with('success', 'User status updated.');
    }

    private function authorizeAdmin()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Admin only.');
        }
    }
}