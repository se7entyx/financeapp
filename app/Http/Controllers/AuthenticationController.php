<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
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
            'username' => 'required|string',
            'password' => 'required|min:8|max:255'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // dd('berhasil');
            return redirect()->intended('/dashboard');
        }
        return back()->with('error', 'Login Failed');
    }

    public function updatePassword(Request $request)
    {
        $credentials = $request->validate([
            'new_password' => 'required|min:8|max:255',
            'confirm_password' => 'required|min:8|max:255'
        ]);

        // $user = User::where('id', Auth::user()->id);
        // dd($user);

        if ($request->new_password !== $request->confirm_password) {
            return back()->withErrors(['confirm_password' => 'The new password and confirm password do not match.']);
        }

        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($credentials['new_password']);
        $user->save();
        return back()->with('status', 'Password successfully changed.');
    }

    public function getUsers(Request $request)
    {
        $users = User::latest()->paginate(20);
        return view('user', ['title' => 'All Users', 'users' => $users]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|max:255',
                'username' => 'required|max:255|unique:users,username', // Ensure username is unique in the users table
                'role' => 'required|string'
            ]
        );

        // dd($validatedData);
        // $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['remember_token'] = Str::random(10);
        $validatedData['password'] = Hash::make('12345678');
        User::create($validatedData);
        // $request->session()->flash('success', 'Registration successfull! Please Login!');
        return redirect('/dashboard/admin/users')->with('success', 'Registration successfull!');
    }

    public function updateUser(Request $request, $id)
    {
        // dd('panggil');
        $credentials = $request->validate([
            'name' => 'required|max:255',
            'username' => [
                'required',
                'string',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'nullable|string|min:8',
            'role' => 'required|string'
        ]);

        // dd($credentials);

        if ($credentials) {
            $user = User::find($id);
            if ($credentials['password'] == '') {
                $credentials['password'] = $user->password;
            }
            $user->name = $credentials['name'];
            $user->username = $credentials['username'];
            $user->password = $credentials['password'];
            $user->role = $credentials['role'];
            $user->save();
            return redirect('/dashboard/admin/users')->with('success', 'Update successfull!');
        } else {
            dd('asq');
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/dashboard/admin/users')->with('successdel', 'Delete successfull!');
    }
}
