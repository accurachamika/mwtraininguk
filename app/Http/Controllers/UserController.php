<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   public function regPost(Request $request) : RedirectResponse {
        $request->validate([
            'user_name' => ['required', 'string' , 'unique:users,user_name'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'user_name' => $request->user_name,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('login'));
    }


    public function logIn(Request $request)  {
        $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);


        $credentials = [
            'user_name' => $request->input('user_name'),
            'password' => $request->input('password')
        ];

        $remember = $request->has('remember');

        if(Auth::attempt($credentials , $remember)){
            $user = Auth::user();
            return redirect()->route('home')->with(['data'=>$user , 'success'=> 'Successfully Logged in']);
        }

        return back()->withErrors([
            'login_error' => 'Invalid credentials or user not found',
        ])->withInput($request->only('user_name'));

    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout(); // Logs out the user

        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect()->route('login'); // Redirect to login page after logout
    }
}
