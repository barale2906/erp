<?php

namespace App\Http\Livewire\Facturacion;

use App\Cuenta;
use App\Diligencia;
use Livewire\Component;
use Livewire\WithPagination;

class Listacuco extends Component
{
    use WithPagination;

    public $ordena='numero';
    public $ordenado='ASC';
    public $porpagina=10;
    public $buscar='';

    public $idcuenta='';

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

   }

   // Listado de cuentas
   private function cuentas()
   {
        return Cuenta::join('users', 'users.id', '=', 'cuentas.operador_id')
                        ->select('users.username', 'users.name', 'cuentas.id', 'cuentas.numero', 'cuentas.valor', 
                            'cuentas.fecha', 'cuentas.observaciones', 'cuentas.estado')
                        ->where('cuentas.numero','like','%'.$this->buscar.'%')
                        ->Orwhere('users.username','like','%'.$this->buscar.'%')
                        ->Orwhere('users.name','like','%'.$this->buscar.'%')
                        ->Orwhere('cuentas.valor','like','%'.$this->buscar.'%')
                        ->Orwhere('cuentas.fecha','like','%'.$this->buscar.'%')
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->porpagina);
   }

   // Cuenta seleccionada
   private function cuentadetalles()
   {
       if(!empty($this->idcuenta))
       {
        return  Diligencia::join('pagodetacuenta', 'pagodetacuenta.producto_id', '=', 'diligencias.id')                        
                        ->join('pagoperador', 'pagoperador.id', '=', 'pagodetacuenta.pagope_id')                        
                        ->select('diligencias.id', 'diligencias.fecha', 'diligencias.comentarios', 'diligencias.observaciones', 
                            'pagodetacuenta.cantidad', 'pagodetacuenta.vr_unitario', 'pagodetacuenta.vr_total',
                            'pagoperador.cargo')
                        ->where('pagodetacuenta.cuenta_id', $this->idcuenta)
                        ->get();
       }
   }

   // Detalles cuenta seleccionada
   private function cuentasele()
   {
       if(!empty($this->idcuenta))
       {
        return Cuenta::join('users', 'users.id', '=', 'cuentas.operador_id')
                        ->select('users.name', 'cuentas.numero', 'cuentas.valor', 'cuentas.fecha', 'cuentas.observaciones', 
                            'cuentas.fechapago', 'cuentas.valorpagado', 'cuentas.observacionespago')
                        ->where('cuentas.id', $this->idcuenta)
                        ->first();
       }
   }

   // Seleccionar cuenta
   public function selid($id)
   {
       $this->idcuenta = $id;
   }

    public function render()
    {
        return view('livewire.facturacion.listacuco', [
            'cuentas'           => $this->cuentas(),
            'cuentasele'        => $this->cuentasele(),
            'cuentadetalles'    => $this->cuentadetalles(),
        ]);
    }
}
