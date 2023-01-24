<?php

namespace App\Http\Livewire\Financiero;

use App\Caja;
use App\Cuenta;
use App\Factura;
use App\Obligacione;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Obligactivas extends Component
{
    use WithFileUploads;

    public $obligacionid;
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
    public $control;  
    
    public $clase;
    public $funcion;
    public $actividad;
    public $alerta;
    public $mensaje;
    public $financierosel;    

    // Recibir variables de otros componentes
    protected $listeners = ['recargar' => 'recargar'];

    // Recargar listado
    public function recargar()
    {
        $this->listado();
    }

    // Cargar datos de obligacion
    public function cargadatos($id, $crt)
    {
        $this->obligacionid = $id;
        $this->control = $crt;
        switch ($crt) {
            case 1:
                $this->clase = "btn-danger";
                $this->funcion = "eliminar";
                $this->actividad = "Eliminar Obligación";
                $this->alerta = "alert-danger";
                $this->mensaje = "¿Esta seguro(a) de eliminar la obligación? esta operación es ¡IRREVERSIBLE!";
                break;
            case 2:
                $this->clase = "btn-success";
                $this->funcion = "pagar";
                $this->actividad = "Registrar Pago";
                $this->alerta = "alert-success";
                $this->mensaje = "Va a registrar pago para esta obligación";
                break;
        }
    }

    // Resetear variables
    public function cerrar()
    {
        $this->reset();
    }
    // Eliminar obligación
    public function eliminar()
    {
        Obligacione::where('id', $this->obligacionid)
                    ->delete();

        if($this->tipo==1){            
            $mensaje = 'Se elimino la obligación: '.$this->nombre.', debe generar obligación para el pago de la cuenta de cobro N° '.$this->numerotipo;            
        } else {
            $mensaje = 'Se elimino la obligación: '.$this->nombre;
        }

        session()->flash('messagelim', $mensaje );

        $alerta = $this->alerta;
        $this->cerrar();
        $this->alerta = $alerta;


    }    

    // Pagar obligación
    public function pagar()
    {
        $now = Carbon::now();
        $financiero = explode("-",$this->financierosel);
        $idfin = $financiero[0];
        $nomfin = $financiero[1];        
        $pagos = $this->obligasel();
        $observa = " --- ".$now." ".Auth::user()->name." Registro el pago de la obligación desde: ".$nomfin." ".$pagos->observaciones;
        $movim = $now." "."pago de la obligación: ".$pagos->nombre;
        $valor = $pagos->pago*-1;
        $descripcion = $now." ".Auth::user()->name." Registro el pago de la obligación.";
        $mensaje = "Se pago la obligación: ".$pagos->nombre.", desde: ".$nomfin;

        // Registrar pago de la obligación
        Obligacione::where('id', $this->obligacionid)
                    ->update([
                        'pagorealizado' => $pagos->pago,
                        'estado'        => 3,
                        'observaciones' => $observa,
                    ]);

        // Cargar soporte
        //mayor numero
        $ididen = Caja::max('id'); 

        $ididen = $ididen+1;

        // Envía imagen al servidor
        $fotonom = Auth::user()->id.'-'.$ididen.'-'.$pagos->id.'.'.$this->soporte->getClientOriginalExtension();
        $this->soporte->storeAs('caja', $fotonom, 'public_soportes');
        $rutafoto = "../caja/".$fotonom;

        // Registrar movimiento de caja
        Caja::create([
            'movimiento'      => $movim,
            'tipo'            => 's',
            'valor'           => $valor,
            'descripcion'     => $descripcion,
            "imagen"          => $rutafoto,
            "usuario"         => Auth::user()->name,
            "user_id"         => Auth::user()->id,
            "financiero_id"   => $idfin,
         ]);


         // Emitir información
        session()->flash('messagelim', $mensaje);

        $alerta = $this->alerta;
        $this->cerrar();
        $this->alerta = $alerta;

    }

    // Obligación seleccionada
    private function obligasel()
    {
        if(!empty($this->obligacionid)){
            $seleccionada = Obligacione::where('id', $this->obligacionid)->first();
        
            return $seleccionada;
        }
    }

    // Productos financieros
    private function financieros()
    {
        if($this->control == 2)
        {
            return Caja::select('financiero_id')
                        ->addSelect(DB::raw('SUM(valor) as saldo'))
                        ->groupBy('financiero_id')
                        ->orderBy('financiero_id', 'ASC')
                        ->get();
        }
    }

    // Listado de obligaciones activas
    private function listado()
    {
        return Obligacione::where('estado', 1)
                            ->get();
    }

    public function render()
    {
        return view('livewire.financiero.obligactivas',[
            'listados'          => $this->listado(),
            'obligasel'         => $this->obligasel(),
            'financieros'       => $this->financieros(),
        ]);
    }
}
