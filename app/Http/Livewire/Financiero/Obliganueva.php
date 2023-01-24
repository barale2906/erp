<?php

namespace App\Http\Livewire\Financiero;

use App\Obligacione;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Obliganueva extends Component
{
    use WithFileUploads;

    public $tipo;
    public $numerotipo;
    public $nombre;
    public $identificacion;
    public $banco;
    public $cuenta;
    public $tipocuenta;
    public $periodica;
    public $fecha;
    public $pago;
    public $observaciones;
    public $soporte;


    // Resetear variables
    public function cerrar()
    {
        $this->reset();
    }

    // Crear obligación
    public function crear()
    {
        $now = Carbon::now();
        
        $this->validate([
            'soporte'   => 'required',            
         ]);

        if(!empty($this->periodica)){
            $periodico = $this->periodica;
        } else {
            $periodico = 0;
        }

        if(!empty($this->numerotipo)){
            $numero = $this->numerotipo;
        } else {
            $numero = NULL;
        }



        $observa = "---".$now." ".Auth::user()->name." creo la obligación. ".$this->observaciones." --- ";

        $obli = Obligacione::create([
            'nombre'            => $this->nombre,
            'identificacion'    => $this->identificacion,
            'banco'             => $this->banco,
            'cuenta'            => $this->cuenta,
            'tipocuenta'        => $this->tipocuenta,
            'periodico'         => $periodico,
            'tipo'              => $this->tipo,
            'numerotipo'        => $numero,
            'fecha'             => $this->fecha,
            'pago'              => $this->pago,
            'observaciones'     => $observa,
            'user_id'           => Auth::user()->id,
        ]);

        if(!empty($this->soporte)){

            // Envía imagen al servidor
            $ididen = $obli->id;
            
            $fotonom = Auth::user()->id.'-'.$ididen.'.'.$this->soporte->getClientOriginalExtension();
            $this->soporte->storeAs('obligacion', $fotonom, 'public_soportes');
            $rutafoto = "../obligacion/".$fotonom;

            Obligacione::where('id', $obli->id)
                        ->update([
                            'soporte'   => $rutafoto,
                        ]);
        }

        $this->reset();

        session()->flash('messagelim', 'Se creo satisfactoriamente la obligación N°: '.$obli->id );

        $this->emit('recargar');
    }

    // Mostrar diligencias periodicas
    public function periomuestra()
    {
        $this->periodica=2;
    }

    // Seleccionar obligacion periodica
    public function obligasele($id)
    {
        $sele = Obligacione::where('id', $id)->first();

        $this->tipo             = $sele->tipo;
        $this->nombre           = $sele->nombre;
        $this->identificacion   = $sele->identificacion;
        $this->banco            = $sele->banco;
        $this->cuenta           = $sele->cuenta;
        $this->tipocuenta       = $sele->tipocuenta;        
    }

    // Obligaciones periodicas.
    private function periodica()
    {
        if($this->periodica==2)
        {
            return Obligacione::where('periodico', true)
                                ->orderBy('tipo', 'ASC')
                                ->get();
        }
    }

    public function render()
    {
        return view('livewire.financiero.obliganueva', [
            'periodicas'            => $this->periodica(),
        ]);
    }
}
