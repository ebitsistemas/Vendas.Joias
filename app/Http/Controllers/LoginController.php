<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ],[
            'email.required' => 'Campo e-mail é obrigatório!',
            'email.email' => 'Este campo deve ter um e-mail válido!',
            'password.required' => 'Campo senha é obrigatório!',
            'password.min' => 'Campo senha é deve conter no mínimo :min caracteres!',
        ]);

        $credentials = $request->only('email', 'password');
        $authenticated = Auth::attempt($credentials);

        if (!$authenticated) {
            return redirect()->route('login.index')->withErrors(['error' => 'E-mail e/ou senha invalido!']);
        }
        return redirect()->to('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        return redirect()->route('login.index');
    }
}
