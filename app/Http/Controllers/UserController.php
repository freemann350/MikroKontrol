<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::all();
        return view('users.index', ['users' =>$users]);
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $formData = $request->validated();

        if (!isset($formData['admin'])) {
            $formData['admin'] = 0;
        } else {
            $formData['admin'] = 1;
        }

        User::create([
            'name' => $formData['name'],
            'password' => $formData['password'],
            'email' => $formData['email'],
            'admin' => $formData['admin'],
        ]);

        return redirect()->route('users_all')->with('success-msg', "An User was added with success");
    }

    public function edit($id): View
    {
        $user = User::findOrFail($id);
        return view('users.edit', ['user' => $user]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $formData = $request->validated();

        if (!isset($formData['admin'])) {
            $formData['admin'] = 0;
        } else {
            $formData['admin'] = 1;
        }

        $user = User::findOrFail($id);
        $user->update($formData);
        if (auth()->user()->admin == 1) {
            return redirect()->route('users_all')->with('success-msg', "An User was updated with success");
        } else {
            return redirect()->back()->withInput()->with('success-msg', "An User was updated with success");
        }
    }

    public function updatePassword(PasswordRequest $request, $id)
    {
        $formData = $request->validated();

        $user = User::findOrFail($id);
        $user->update($formData);
        if (auth()->user()->admin == 1) {
            return redirect()->route('users_all')->with('success-msg', "An User was updated with success");
        } else {
            return redirect()->back()->withInput()->with('success-msg', "An User was updated with success");
        }
    }


    public function show(): View
    {
        return view('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users_all')->with('success-msg', "An User was deleted with success");
    }
}
