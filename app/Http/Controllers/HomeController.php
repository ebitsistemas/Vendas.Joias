<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function cep(Request $request)
    {
        $response = Http::get("https://viacep.com.br/ws/{$request->cep}/json/");

        if (isset($response->json()['localidade'])) {
            return response()->json([
                'success' => true,
                'item' => $response->json()
            ]);
        } else {
            return [
                'success' => false,
                'erro' => ''
            ];
        }
    }
}
