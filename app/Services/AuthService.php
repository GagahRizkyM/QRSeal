<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    // Your service logic here
    public static function login($data)
    {
        // check if user active
        $user = User::where('email', $data['email'])->first();
        if(!$user){
            throw new Exception('Username you entered not found');
        }
        //  check password

        $credentials = $data->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            throw new Exception('Password you entered is wrong');
        }
    }

    // logout
    public static function logout()
    {
        Auth::logout();
    }

    // check if user logged in
    public static function check()
    {
        return Auth::check();
    }

    // check if user active in session if not logout
    public static function checkActive()
    {
        if(Auth::check()){
            $user = Auth::user();
            if(!$user->active){
                Auth::logout();
            }
        }
    }

    // get user data with role
    public static function user()
    {
        return Auth::user();
    }

    public static function register($data){
        try {
            //code...
            $user = new User();
            $user->name = $data['username'];
            $user->email = $data['email'];
            $user->role = $data['role'];
            $user->password = bcrypt($data['password']);
            $user->save();
            return $user;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
