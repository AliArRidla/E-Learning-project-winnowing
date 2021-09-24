<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function messages()
    {
        return [
            'name.required' => 'Mohon isi kolom Nama',
            'email.required' => 'Mohon isi kolom Email',
            'email.email' => 'Format Email Anda salah',
            'email.unique' => 'Email sudah terpakai. Mohon gunakan Email lain',
            'password.required' => 'Mohon isi kolom Password',
            'password.confirmed' => 'Password tidak sama',
        ];
    }
    
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        Auth::login(
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ])
        );

        $user->attachRole('admin');
        Admin::create([
            'user_id' => $user->id,
            // 'name' => $request->name,
        ]);

        event(new Registered($user));

        // return route('dashboard');

        return redirect(RouteServiceProvider::HOME);
    }
}
