<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Termwind\Components\Hr;

use function Laravel\Prompts\alert;

class AuthenticationController extends Controller
{
    public function showLoginForm()
    {
        return view('login', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:255'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Login Failed');
    }

    public function updatePassword(Request $request)
    {
        $credentials = $request->validate([
            'current_password' => 'required|min:8|max:255',
            'new_password' => 'required|min:8|max:255',
            'confirm_password' => 'required|min:8|max:255'
        ]);

        // $user = User::where('id', Auth::user()->id);
        // dd($user);

        if (!Hash::check($credentials['current_password'], Auth::user()->password)) {
            return back()->with('error', 'Change Password Failed');
        } else {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($credentials['new_password']);
            $user->save();
            return redirect()->intended('/dashboard');
        }
    }
}
