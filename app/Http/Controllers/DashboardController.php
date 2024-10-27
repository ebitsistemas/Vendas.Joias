<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Venda;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $clientes = Cliente::count();
        $nVendas = Venda::count();
        $vendas = Venda::sum('total_liquido');
        return view('dashboard')->with(['clientes' => $clientes, 'vendas' => $vendas, 'nVendas' => $nVendas]);
    }
}
