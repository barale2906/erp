<?php

namespace App\Http\Controllers\api;

use App\Empresa;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ActualEmpresaController extends Controller
{
    public function empresabasico()
    {
        //$idemp = Auth::user();

        $this->middleware('auth');
        $this->user =  Auth::user();

      // $empresabasico = Empresa::where('id', $idemp->empresa)->first();

        //return  compact('empresabasico', 'idemp');

        return  compact('user');

    }
}
