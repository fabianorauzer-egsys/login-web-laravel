<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    public function index()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $nickname = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $response = Http::post('http://localhost:9090/users', [
            'nickname' => $nickname,
            'email' => $email,
            'password' => $password,
        ])->json();

        if (!isset($response['error'])) {
            return redirect('/login');
        } else {
                return redirect()
                ->route("registerPage")
                ->with("message", "As credenciais escolhidas já estão sendo utilizadas")
                ->with("hasMessage", true)
                ->with("messageType", "warning");
        }
    }
}
