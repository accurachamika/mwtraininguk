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
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   public function regPost(Request $request) : RedirectResponse {
        $request->validate([
            'user_name' => ['required', 'string' , 'unique:users,user_name' , 'regex:/^[a-zA-Z0-9]+$/' , 'min:3'],
            'password' => ['required', Rules\Password::defaults()],
        ] , [
            'user_name.required' => 'The username is required.',
            'user_name.min' => 'The username must be at least 3 characters long.',
            'user_name.regex' => 'The username can only contain alphabetic letters and numbers.',
            'user_name.unique' => 'The username has already been taken.',
        ]);

        $user = User::create([
            'user_name' => $request->user_name,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('login')->with(['success'=> 'Account created successfully.Please wait for Admin approval!']);
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
            if($user->active === 0){
                return back()->withErrors([
                    'login_error' => 'User not activated. Please contact admin',
                ]);
            }
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


    public function runSeeder()
    {
        Artisan::call('db:seed', ['--class' => 'UsersTableSeeder']);
        return 'Seeder has been executed!';
    }
    

    public function acc_activate($id) {
        $user = User::find($id);

        if($user->active === 0){
            $user->active = 1;
        }else{
            $user->active = 0;
        }

        if($user->save()){
            return redirect()->route('userlist')->with('success', ($user->active === 1) ? 'User Successfully Activated' : 'User Successfully Deactivated');
        }else{
            return redirect()->route('userlist')->with('error', ($user->active === 1) ? 'User fail to Activate' : 'User fail to Deactivate');
        }
    }

    public function bulk_activate() {
        $users = User::all();

        foreach ( $users as $user) {
            if($user->active === 0){
                $user->active = 1;
            }
            $user->save();
        }

        return redirect()->route('userlist')->with('success',  'Users are Successfully Activated');
        
    }
}
