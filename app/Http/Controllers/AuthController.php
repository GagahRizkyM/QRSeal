<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
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
        return redirect(route('home'));
    }

    public function logout()
    {
        AuthService::logout();
        return redirect(route('login'));
    }
}
