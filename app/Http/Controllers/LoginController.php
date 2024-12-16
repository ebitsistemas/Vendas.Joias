<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

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
            'password' => 'required|min:5',
        ],[
            'email.required' => 'Campo e-mail é obrigatório!',
            'email.email' => 'Este campo deve ter um e-mail válido!',
            'password.required' => 'Campo senha é obrigatório!',
            'password.min' => 'Campo senha é deve conter no mínimo :min caracteres!',
        ]);

        $credentials = $request->only('email', 'password');
        $authenticated = Auth::attempt($credentials);

        if (!$authenticated) {
            return redirect()->route('login')->withErrors(['error' => 'E-mail e/ou senha invalido!']);
        }
        ClienteController::disable();

        return redirect()->to('');
    }

    public function forgot(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('login.forgot-password');
        } else {
            $request->validate(['email' => 'required|email']);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
