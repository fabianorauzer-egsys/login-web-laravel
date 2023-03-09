<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $url = 'http://127.0.0.1:9090/login';
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        $response = Http::post($url, $data);
        if ($response->successful()) {
            $request->session()->push('token', $response->body());
            return redirect()
                    ->route("beers");
        } else {
            return redirect()
                ->route("auth")
                ->with("message", "Usuário e/ou senha inválidos.")
                ->with("hasMessage", true)
                ->with("messageType", "warning");
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('token');
        return redirect()
                ->route("auth");
    }

    public function refresh()
    {
        $token = auth('api')->refresh(); //cliente encaminhe um jwt válido
        return response()->json(['token' => $token]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}
