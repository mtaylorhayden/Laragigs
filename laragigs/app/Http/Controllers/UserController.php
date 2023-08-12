<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // show register/create form
    public function create()
    {
        return view('users.register');
    }

    // store / create user
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            // checks the email is unique to the users table -> email
            'email' => ['required', 'email', Rule::unique("users", "email")],
            // makes sure password == password_{whatever}
            'password' => 'required|confirmed|min:6'
        ]);

        // hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // create user
        $user = User::create($formFields);

        // login user
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in!');
    }

    // logs user out
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out');
    }

    // show login form
    public function login()
    {
        return view('users.login');
    }

    // logs the user in
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You have been logged in');
        }

        // if fails
        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
}
