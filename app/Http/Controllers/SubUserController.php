<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

class SubUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // you could also constrain to admin only creation/editing: behave like admin
    }

    // list sub users for admin (or for parent user show their sub-users)
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $subUsers = User::where('user_type','sub_user')->paginate(15);
        } else {
            // show only sub users of logged-in user
            $subUsers = Auth::user()->subUsers()->paginate(15);
        }
        return view('subusers.index', compact('subUsers'));
    }

    public function create()
    {
        // only admin or parent user can create subusers; admin allowed
        if (!Auth::user()->isAdmin()) {
            // non-admin parent creates sub user under themselves
            return view('subusers.create', ['parent_id' => Auth::id()]);
        }

        return view('subusers.create', ['parent_id' => null]);
    }

    public function store(StoreUserRequest $request)
    {
        // who can create: admin or authenticated user
        $data = $request->validated();
        $data['user_type'] = 'sub_user';
        $data['activation_token'] = \Illuminate\Support\Str::random(64);
        $data['user_status'] = 'inactive';
        // if non-admin creating, force parent_id to auth user
        if (!Auth::user()->isAdmin()) {
            $data['parent_id'] = Auth::id();
        }
        User::create($data);

        return redirect()->route('subusers.index')->with('success', 'Sub user created. Activation link shown on listing.');
    }

    public function edit($id)
    {
        $sub = User::where('user_id', $id)->firstOrFail();

        // admin can edit; parent can edit their sub users
        if (!Auth::user()->isAdmin() && $sub->parent_id !== Auth::id()) {
            abort(403);
        }

        return view('subusers.edit', compact('sub'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $sub = User::where('user_id', $id)->firstOrFail();

        if (!Auth::user()->isAdmin() && $sub->parent_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $sub->update($data);

        return redirect()->route('subusers.index')->with('success', 'Sub user updated.');
    }

    public function destroy($id)
    {
        $sub = User::where('user_id', $id)->firstOrFail();

        if (!Auth::user()->isAdmin() && $sub->parent_id !== Auth::id()) {
            abort(403);
        }

        $sub->delete();

        return redirect()->route('subusers.index')->with('success', 'Sub user removed.');
    }
}