<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Auth_Controller extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function registerPost(Request $request)
    {
        $user = new User();

        $user->username = $request->username;
        $user->password = Hash::make($request->password);

        $user->save();

        return back()->with('success', 'Register successfully');
    }
    public function login()
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
        $credetials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credetials)) {
            toast('Login Berhasil', 'success')->position('center-end');
            return redirect('/home')->with('success', 'Login berhasil');
        }
        toast('Username atau Password Salah !!!', 'error');
        return back()->with('error', 'Email or Password salah');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
    public function profileUser($id)
    {
        $user = User::find($id);
        // dd($user);
        return view('profile', compact('user'));
    }
    public function updateUser(Request $request, int $id)
    {
        $user = User::find($id);

        $this->validate($request, [
            'password' => 'required',
        ]);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // $user->save();
        toast('Password Berhasil Diubah', 'success')->position('center-end');
        return redirect('/home');
    }
}
