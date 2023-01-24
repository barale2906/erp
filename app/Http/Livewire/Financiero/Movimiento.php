<?php

namespace App\Http\Livewire\Financiero;

use App\Caja;
use App\Financiero;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Movimiento extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $financieroid;
    public $financierosel;
    public $financieronombre;

    public $usuarioid;
    public $usuario;
    public $ususaldo;

    public $valor;
    public $descripcion;
    public $movimiento;
    public $usude;
    public $foto;
    public $efectivo;

    public $muestramovimi;
    public $ordena='id';
    public $ordenado='ASC';
    public $porpagina=50;
    public $buscar='';

    


    // CONTROLES DE BUSQUEDAS
   public function ordena($campo)
   {
      if($this->ordenado == 'ASC')
      {
         $this->ordenado = 'DESC';
      }else{
         $this->ordenado = 'ASC';
      }
      return $this->ordena = $campo;

      $this->movimientos();

   }

   // resetear numeración
   public function updatingbuscar()
   {
         $this->resetPage();
   }

   public function updatingporpagina()
   {
         $this->resetPage();
   }

    private function financieros()
    {
        return Financiero::where('estado', 1)->orderBy('nombre', 'ASC')->get();
    }

    private function movimientos()
    {
        if($this->financieroid==1 && !empty($this->usuarioid))
        {
            $movimi = Caja::query()
                            ->Buscar($this->buscar)               // Asi llama al scope 
                            ->where('financiero_id', $this->financieroid)
                            ->where('user_id','like', $this->usuarioid)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->porpagina);
        }else{
            $movimi = Caja::query()
                            ->Buscar($this->buscar)               // Asi llama al scope 
                            ->where('financiero_id', $this->financieroid)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->porpagina);
        }       

        return $movimi;
    }

    // Saldo del producto
    private function saldo()
    {
        if($this->financieroid)
        {
            return Caja::where('financiero_id', $this->financieroid)->get();
        }
    }

    // Saldo por persona en efectivo
    private function saldoindi()
    {
        if($this->financieroid==1 || $this->efectivo==1)
        {
            return Caja::where('financiero_id', 1)
                        ->select('user_id', 'usuario')
                        ->addSelect(DB::raw('SUM(valor) as saldo'))
                        ->groupBy('user_id', 'usuario')
                        ->orderBy('usuario', 'ASC')
                        ->get();
        }
    }

    // Saldo por producto
    private function saldoproductos()
    {
        if(!empty($this->financieroid))
        {
            $nombre = Financiero::where('id', $this->financieroid)->select('nombre')->first();

            $this->financieronombre = $nombre->nombre;

            return Caja::where('financiero_id', '!=', 1)->select('financiero_id')
                        ->addSelect(DB::raw('SUM(valor) as saldo'))
                        ->groupBy('financiero_id')
                        ->orderBy('financiero_id', 'ASC')
                        ->get();
        }        
    }
    
    // Seleccionar producto financiero
    public function seleccionafinanciero()
    {
        $seleccionado = $this->financierosel;
        $this->reset();
        $this->financieroid = $seleccionado;
        $this->financierosel = $seleccionado;
    }

    // Liberar variables
    public function cancelar()
    {
        $this->reset(['usuario', 'usuarioid', 'ususaldo', 'valor', 'descripcion', 'movimiento', 'usude', 'foto', 'muestramovimi', 'efectivo']);
    }

    // Asignar valor a variables de usuario
    public function ususele($saldo, $idusu)
    {       
        $usuario = User::where('id', $idusu)->select('name')->first();

        $this->usuario      = $usuario->name;
        $this->usuarioid    = $idusu;
        $this->ususaldo     = $saldo;
    }    

    // Asignar
    public function cargar()
   {
       

        $this->validate([
            'descripcion'   => 'required',
            'valor'         => 'required',
            'foto'          => 'required',
        ]);

        //mayor numero
        $ididen = Caja::max('id');

        $ididen = $ididen+1;

        // Envía imagen al servidor
        $fotonom = Auth::user()->id.'-'.$ididen.'.'.$this->foto->getClientOriginalExtension();
        $this->foto->storeAs('caja', $fotonom, 'public_soportes');
        $rutafoto = "../caja/".$fotonom;
        

        switch ($this->movimiento) {
            case 1:
                $tipo    = 'e';
                $valor   = $this->valor;
                $movim   = 'Ingreso de dinero al producto';
                $mensaje = "Se cargarón: $ ".number_format($this->valor, 0, ',', ' ')." a: ".$this->financieronombre;
                break;
            case 2:
                $tipo    = 's';
                $valor   = $this->valor*-1;
                $movim   = 'Sálida de dinero del producto';               
                $mensaje = "Se retirarón: $ ".number_format($this->valor, 0, ',', ' ')." de: ".$this->financieronombre;
                break;
        }
      
        // Definir usuario del movimiento
        if($this->financieroid == 1){
            $usu = $this->usuario;
            $usuid = $this->usuarioid;
        } else {
            $usu = Auth::user()->name;
            $usuid = Auth::user()->id;
        }

        Caja::create([
            'movimiento'      => $movim,
            'tipo'            => $tipo,
            'valor'           => $valor,
            'descripcion'     => $this->descripcion,
            "imagen"          => $rutafoto,
            "usuario"         => $usu,
            "user_id"         => $usuid,
            "financiero_id"   => $this->financieroid,
        ]);

      // Descargar otro producto financiero
      if($this->usude>=1)
        {
            switch ($this->movimiento) {
                case 1:
                    $tipo    = 's';
                    $valor   = $this->valor*-1;
                    $movim   = 'Entrego dinero a: '.$this->financieronombre; 
                    break;
                case 2:
                    $tipo    = 'e';
                    $valor   = $this->valor;
                    $movim   = 'Ingreso de dinero de: '.$this->financieronombre;                                
                    break;
            }

            switch ($this->efectivo) {
                case 1:
                        $carga = explode("-",$this->usude);
                        $id = $carga[0];
                        $nombre = $carga[1];
                        $producto = 1;
                        break;
                case 2:
                        $nombre = Auth::user()->name;
                        $id = Auth::user()->id;
                        $producto = $this->usude;
                        break;
            }
            
            Caja::create([
                    'movimiento'      => $movim,
                    'tipo'            => $tipo,
                    'valor'           => $valor,
                    'descripcion'     => $this->descripcion,
                    "imagen"          => $rutafoto,
                    "usuario"         => $nombre,
                    "user_id"         => $id,
                    "financiero_id"   => $producto,
                ]);
        }

      // Emitir información
      session()->flash('suceso', $mensaje);

      // Limpirar variables
      $this->cancelar();

   }

    // Muestra movimientos
    public function movimientomuestra($id)
    {
        $this->muestramovimi = 1;
        if(!empty($id))
        {
            $this->usuarioid = $id;
        } 
        
    }

    public function render()
    {        
        return view('livewire.financiero.movimiento', [
            'financieros'           => $this->financieros(),
            'saldo'                 => $this->saldo(),
            'saldoindi'             => $this->saldoindi(),
            'saldoproductos'        => $this->saldoproductos(),
            'movimientos'           => $this->movimientos(),
        ]);
    }
}
