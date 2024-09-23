<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOld;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DataMigrationController extends Controller
{
    public function migrateUsers()  {

        ini_set('max_execution_time', 1000);
       
        $userOld = UserOld::select('std_id', 'password','reg_date')->get();

        foreach ($userOld as $user) {

            if($user->std_id === null || $user->std_id === ''){
                continue;
            }

            $exist = User::where('user_name' , $user->std_id)->first();
           
            if(!$exist){
                $u = User::create([
                    'user_name' => $user->std_id,
                    'password' => Hash::make($user->password),
                    'created_at' => $user->reg_date === 0 || $user->reg_date === null ? Carbon::now() : $user->reg_date ,
                ]);
                event(new Registered($u));
            }
        }

        return redirect()->route('userlist')->with('success', 'Users are Successfully migrated');


    }

    public function truncateUsers()  {
        User::truncate();
        Artisan::call('db:seed', ['--class' => 'UsersTableSeeder']);

        return redirect()->route('userlist')->with('success', 'Users are Successfully deleted');
    }


}
