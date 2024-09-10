<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;


class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   public function regPost(Request $request) : RedirectResponse {
        $request->validate([
            'username' => ['required', 'string' , 'lowercase', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        return redirect('login');
    }
}
