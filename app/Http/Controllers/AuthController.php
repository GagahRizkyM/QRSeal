<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function login()
    {
        $props = [
            'title' => 'Login',
        ];
        return view('login',$props);
    }

    public function auth(LoginRequest $request)
    {
        try {
            AuthService::login($request);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        $request->session()->regenerate();
        return redirect(route('home'));
    }

    public function logout()
    {
        AuthService::logout();
        return redirect(route('login'));
    }

    public function register(RegisterRequest $request){
        try {
            $register = AuthService::register($request->all());
            if($register){
                return redirect()->route('register')->with('success', 'Account has been created successfully');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
