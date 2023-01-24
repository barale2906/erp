<?php

namespace App\Http\Livewire\Facturacion;

use App\Caja;
use App\Factura;
use App\Financiero;
use App\Producto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Listafactura extends Component
{


   // Paginación
   use WithPagination;

   //Archivos
   use WithFileUploads;

   public $ordena='id';
   public $ordenado='ASC';
   public $porpagina=10;
   public $buscar='';

   public $idfactura=0;
   public $control;

   public $obsanular;

   public $valorpago;
   public $valorimpu;
   public $financiero;
   public $fechapago;
   public $soporte;
   public $observaciones;
   public $class='alert-info';

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

      $this->listasig();

   }

   // Listado de facturas
   private function facturas()
   {
      if($this->idfactura==0)
      {
         return Factura::join('empresas', 'empresas.id', '=', 'facturas.cliente_id')
            ->join('sucursales', 'sucursales.id', '=', 'facturas.sucursal_id')
            ->select('facturas.id', 'facturas.numero', 'facturas.valor', 'facturas.fecha', 'facturas.estado',
                     'empresas.nit', 'empresas.nombre', 'sucursales.nombre as sucursal' )
            ->where('numero','like','%'.$this->buscar.'%')
            ->Orwhere('valor','like','%'.$this->buscar.'%')
            ->Orwhere('fecha','like','%'.$this->buscar.'%')
            ->Orwhere('nit','like','%'.$this->buscar.'%')
            ->Orwhere('empresas.nombre','like','%'.$this->buscar.'%')
            ->Orwhere('sucursales.nombre','like','%'.$this->buscar.'%')
            ->orderBy($this->ordena, $this->ordenado)
            ->paginate($this->porpagina);
      }
   }

   // Factura seleccionada
   private function actual()
   {
      if($this->idfactura>0)
      {
         return Factura::join('empresas', 'empresas.id', '=', 'facturas.cliente_id')
                           ->join('sucursales', 'sucursales.id', '=', 'facturas.sucursal_id')
                           ->select('facturas.*', 'empresas.nombre', 'empresas.nit', 'sucursales.nombre as sucursal', 'sucursales.direccion')
                           ->where('facturas.id', $this->idfactura)
                           ->first();
      }
   }

   // detalles facturas
   private function detalles()
   {
      if($this->idfactura>0)
      {
         return Producto::join('lppros', 'lppros.producto', '=', 'productos.id')
                           ->join('detafacturas', 'detafacturas.producto_id', '=', 'lppros.id')
                           ->where('detafacturas.factura_id', $this->idfactura)
                           ->select('productos.producto', 'productos.descripcion', 'lppros.alias', 'detafacturas.*')
                           ->orderBy($this->ordena, $this->ordenado)
                           ->get();

      }
   }

   // Ruta descarga
   private function zip()
   {
      if($this->idfactura>0)
      {
         return Factura::join('facturazips', 'facturazips.factura_id', '=', 'facturas.id')
                           ->select('facturazips.*')
                           ->where('facturas.id', $this->idfactura)
                           ->first();
      }
   }

   // Cuentas de la empresa
   private function cuentas()
   {
      return Financiero::where('estado', 1)
                        ->select('nombre', 'id')
                        ->orderBy('nombre', 'ASC')
                        ->get();
   }

   // Selecciona factura
   public function selid($id, $crt)
   {
      $this->idfactura = $id;
      $this->control = $crt;
      $this->ordena='id';
   }

   // Anular factura
   public function anula()
   {
      // Fecha de hoy
      $now = Carbon::now();

      // Seleccionar Factura
      $obsfactura = Factura::where('id', $this->idfactura)->select('observacionesfactura')->first();

      $obs = $now.": ".Auth::user()->name." ANULÓ LA FACTURA con la observación: ".$this->obsanular."- ".$obsfactura->observacionesfactura;

      Factura::where('id', $this->idfactura)
               ->update([
                  'observacionesfactura'  => $obs,
                  'estado'                => 5,
               ]);

      // Informar
      session()->flash('suceso', 'Se anulo correctamente la factura');

      // Resetear la variable
      $this->reset(['obsanular']);
   }

   // Registrar pago
   public function cargapago()
   {
      
      $this->validate([
         'financiero'      => 'required',
         'fechapago'       => 'required',
         'valorpago'       => 'required',
         'valorimpu'       => 'required',
         'soporte'         => 'required|mimes:pdf',
         'observaciones'   => 'required',         
      ]);
      
      
      // Seleccionar factura actual
      $actual = Factura::where('id', $this->idfactura)->first();

      $total = $this->valorpago+$this->valorimpu;
      $deudaactual = $actual->valor-$actual->impuesto-$actual->valorpagado;
      $control = $deudaactual-$total;
      
      

      if($control>=0)
      {
         // Fecha de hoy
         $now = Carbon::now();

         $obserpago = " -- El ".$now.": ".Auth::user()->name." registro: ".$this->observaciones." -- ".$actual->observacionespago;
         $valorpagado = $this->valorpago+$actual->valorpagado;
         $impuesto = $this->valorimpu+$actual->impuesto;

         if($control==0)
         {
            $estado = 4;
         }
         if($control>0)
         {
            $estado = 3;
         }

         //Actualizar factura
         Factura::where('id', $this->idfactura)
                  ->update([
                     'impuesto'           => $impuesto,
                     'fechapago'          => $this->fechapago,                     
                     'valorpagado'        => $valorpagado,
                     'observacionespago'  => $obserpago,
                     'estado'             => $estado,
                  ]);

         //Cargar soporte
         //mayor numero
         $ididen = DB::table('cajas')
                     ->max('id');

         $ididen = $ididen+1;

         $idfactu = $this->idfactura;


         // Envía imagen al servidor
         
         $fotonom = $idfactu.'-'.Auth::user()->id.'-'.$ididen.'.'.$this->soporte->getClientOriginalExtension();         
         $this->soporte->storeAs('caja', $fotonom, 'public_soportes');
         $rutafoto = "../caja/".$fotonom;
         
         /*
         $archivo = new ImageManager();
         $cargar = $archivo->make('caja/'.$fotonom)->resize(600,400);
         $cargar->save('caja/'.$fotonom); */

         



         //Registrar caja         
         $idpago = Caja::create([
                        'movimiento'         => 'Registro pago de factura: '.$actual->numero,
                        'tipo'               => 'e',
                        'valor'              => $this->valorpago,
                        'descripcion'        => $this->observaciones,
                        'documento'          => $this->fechapago,
                        'imagen'             => $rutafoto,
                        "usuario"            => Auth::user()->name,
                        "user_id"            => Auth::user()->id,
                        'financiero_id'      => $this->financiero,
                     ]);

         //Registrar pago de la factura
         DB::table('caja_factura')
            ->insert([
               'caja_id'      => $idpago->id,
               'factura_id'   => $this->idfactura,
               'valor'        => $this->valorpago,
               'created_at'   => $now,
               'updated_at'   => $now,
            ]);

         $mensaje = "Se ha registrado correctamente el pago a la factura";

         $this->reset(['financiero', 'fechapago', 'valorpago', 'valorimpu', 'observaciones', 'soporte']);


      } else {
         $mensaje = "El valor pagado es mayor a la deuda, por favor verifique los datos registrados";
         $this->class = "alert-warning";
      }
      
      // Emitir información
      session()->flash('factura', $mensaje);

   }

   // resetear busqueda
   public function limpiar()
   {
      $this->reset();
   }

   public function render()
   {
      return view('livewire.facturacion.listafactura', [
         'facturas'     => $this->facturas(),
         'actual'       => $this->actual(),
         'detalles'     => $this->detalles(),
         'zip'          => $this->zip(),
         'cuentas'      => $this->cuentas(),
      ]);
   }
}

// 1 En proceso 2 Finalizada, 3 Abonada, 4 Pagada, 5 Anulada
