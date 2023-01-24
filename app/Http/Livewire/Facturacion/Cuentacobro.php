<?php

namespace App\Http\Livewire\Facturacion;

use App\Cuenta;
use App\Diligencia;
use App\Factura;
use App\Obligacione;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Null_;

class Cuentacobro extends Component
{
   public $operador;
   public $cuentapro;
   public $serviciocrt;
   public $cobros;
   public $idesquema;
   public $idcuenta;
   public $proceso;
   public $observaciones;
   public $puerta=1;
   public $numerocuenta;
   public $cantidad;
   public $fechaini;
   public $fechafin;

   public $banco;
   public $cuentapago;
   public $tipocuentapago;
   public $bancoc;
   public $cuentapagoc;
   public $tipocuentapagoc;


   // operadores
   private function operadores()
   {
      /*
      return User::join('detafacturas', 'detafacturas.operador_id', '=', 'users.id')
                  ->whereNull('detafacturas.cuentacobro')
                  ->select('detafacturas.operador_id', 'users.name')
                  ->groupBy('detafacturas.operador_id', 'users.name')
                  ->orderBy('users.name')
                  ->get(); */

      return Diligencia::join('dilioperadors', 'dilioperadors.diligencia_id', '=', 'diligencias.id')
                        ->join('users', 'users.id', '=', 'dilioperadors.usuario_id')
                        ->whereNull('dilioperadors.cuentacobro')
                        ->whereIn('dilioperadors.estado', [1,2,4])                        
                        ->select('users.id', 'users.name')
                        ->groupBy('users.id', 'users.name')
                        ->orderBy('users.name', 'ASC')
                        ->get();

   }

   // Operador seleccionado
   private function opeseleccionado()
   {
      return User::where('id', $this->operador)
                  ->select('name')
                  ->first();
   }

   // Cambiar de operador
   public function cambiaoperador()
   {
      $this->operador      =  "";
      $this->idcuenta      =  "";
      $this->serviciocrt   =  "";
      $this->proceso       =  "";
      $this->puerta        =  1;
   }

   // Listado de cuentas en proceso
   private function cuentaproceso()
   {
      if(empty($this->operador)){
         $cuentaproceso =  Cuenta::join('users', 'users.id', '=', 'cuentas.operador_id')
                              ->where('cuentas.estado', 1)
                              ->select('users.name', 'cuentas.id', 'cuentas.fecha')
                              ->orderBy('users.name', 'ASC')
                              ->orderBy('cuentas.fecha', 'ASC')
                              ->get();

         if($cuentaproceso->count()){
            $this->cuentapro = 1;
            return $cuentaproceso;
         }
      }
   }

   // Seleccionar lista en proceso
   public function seleccionacuenta()
   {
      $seleccionada = Cuenta::where('id', $this->proceso)
                           ->select('operador_id')
                           ->first();

         $this->operador      =  $seleccionada->operador_id;
         $this->idcuenta      =  $this->proceso;

         session()->flash('periodo', 'Ha sido seleccionada correctamente la cuenta');
   }

   // Mostrar Mensaje de eliminación
   public function abrir($id)
   {
      $this->puerta = $id;
   }

   // Cerrar Mensaje de eliminación
   public function cerrar()
   {
      $this->puerta = 1;
   }

   // Seleccionar items pendientes
   private function seleccionados()
   {
      if(!empty($this->operador))
      {
         $this->serviciocrt=2;
         $this->numerocuenta='';        

         return Diligencia::join('dilioperadors', 'dilioperadors.diligencia_id', '=', 'diligencias.id')
                        ->whereNull('dilioperadors.cuentacobro')
                        ->where('dilioperadors.usuario_id', $this->operador)
                        ->whereIn('dilioperadors.estado', [1,2,4])
                        ->select('dilioperadors.id', 'diligencias.id as numerodili', 'diligencias.fecha', 'diligencias.comentarios', 
                                 'diligencias.observaciones', 'diligencias.guias')                        
                        ->orderBy('diligencias.fecha', 'ASC')
                        ->get();

                        /*SELECT * FROM `dilioperadors` INNER JOIN `diligencias` ON `dilioperadors`.`diligencia_id`=`diligencias`.`id` WHERE `dilioperadors`.`usuario_id`=60 AND `diligencias`.`fecha`>='2021-07-24'*/ 

      }
   }

   // Esquema vigente
   private function esquemavig()
   {
      if(!empty($this->operador))
      {
         $now = Carbon::now();
         $esquemav = DB::table('pagoesquema')
                        ->where('pagoesquema.estado', 2)
                        ->whereDate('pagoesquema.inicio', '<=', $now)
                        ->whereDate('pagoesquema.fin', '>=', $now)
                        ->select('id', 'esquema', 'inicio', 'fin')
                        ->first();
         if($esquemav)
         {
            $this->idesquema = $esquemav->id;

            return $esquemav;
         }
      }
   }

   // Esquema de costos vigente
   private function costos()
   {
      return DB::table('pagoesquedeta')
                  ->join('pagoperador', 'pagoperador.id', '=', 'pagoesquedeta.pago_id')
                  ->where('pagoesquedeta.esquema_id', $this->idesquema)
                  ->select('pagoesquedeta.id', 'pagoesquedeta.pago_id', 'pagoesquedeta.valor', 'pagoperador.cargo')
                  ->orderBy('pagoperador.cargo', 'ASC')
                  ->get();
   }

   // Verifica datos de pago
   private function datopago()
   {
      if($this->puerta==3){
         $datospago = DB::table('usercontacto')
                        ->where('user_id', $this->operador)
                        ->where('estado', 1)
                        ->first();

         if($datospago){
            $this->banco = $datospago->banco;
            $this->cuentapago = $datospago->cuenta;
            $this->tipocuentapago = $datospago->tipocuenta;
         }

         return $datospago;
      }
   }

   // Crea datos pago
   public function creadatospago()
   {
      // Fecha de hoy
      $now = Carbon::now();

      $actual = DB::table('usercontacto')
                     ->where('user_id', $this->operador)
                     ->where('estado', 1)
                     ->first();

      if($actual)
      {
         DB::table('usercontacto')
               ->where('id', $actual->id)
               ->update([
                  'estado' => 0,
               ]);
         $direccion = $actual->direccion;
         $telefono = $actual->telefono;
      } else {
         $direccion = Null;
         $telefono = Null;
      }

      // Crea registro
      DB::table('usercontacto')
               ->insert([
                  'fecha'        => $now,
                  'user_id'      => $this->operador,
                  'direccion'    => $direccion,
                  'banco'        => $this->bancoc,
                  'cuenta'       => $this->cuentapagoc,
                  'tipocuenta'   => $this->tipocuentapagoc,
                  'telefono'     => $telefono,
                  'estado'       => 1,
               ]);

      $this->datopago();

   }

   // Selecciona cobro
   public function seleccionacobro($id)
   {
      // Fecha de hoy
      $now = Carbon::now();

      // Seleccionar registro actual
      $actual = Diligencia::join('dilioperadors', 'dilioperadors.diligencia_id', '=', 'diligencias.id')
                           ->select('diligencias.guias')
                           ->where('dilioperadors.id', $id)
                           ->first();
      

      //Obtener datos de pago
      $valores = explode( '-',$this->cobros);

      

      // Valor obtenido
      $vrtotal = $actual->guias*$valores[1];

      

      // Verificar existencia de cuenta
      if(!empty($this->idcuenta))
      {
         
         
         // Totalizar cuenta de cobro
         $totactual = Cuenta::where('id', $this->idcuenta)
                              ->select('valor')
                              ->first();
         // nuevo valor
         $totalnue = $totactual->valor+$vrtotal;

         // Actualizar Valor
         Cuenta::where('id', $this->idcuenta)
               ->update([
                  'valor'  => $totalnue,
               ]);


         
         
      } else
      {
         // Crear cuenta
         $cuenta = Cuenta::create([
            'genero'       => Auth::user()->id,
            'operador_id'  => $this->operador,
            'valor'        => $vrtotal,
            'fecha'        => $now,
         ]);

         $this->idcuenta = $cuenta->id;
         
      }
      
         // Insertar detalle de cuenta
         DB::table('pagodetacuenta')
            ->insert([
               'cuenta_id'    => $this->idcuenta,
               'pagope_id'    => $valores[0],
               'producto_id'  => $id, // En este campo se guardará el id de la dilioperadors
               'cantidad'     => $actual->guias,
               'vr_unitario'  => $valores[1],
               'vr_total'     => $vrtotal,
               'clase'        => 0,
            ]);

      // Actualizar tabla de dilioperadors
      DB::table('dilioperadors')
         ->where('id', $id)
         ->update([
            'cuentacobro'   => $this->idcuenta,            
         ]);
      $this->cobros="";
   }

   // Asignar cargos no facturados
   public function adicionales($id)
   {
      // Fecha de hoy
      $now = Carbon::now();

      // Datos del costo
      $costosel = DB::table('pagoesquedeta')
                        ->where('id', $id)
                        ->select('pago_id','valor')
                        ->first();

      $vrtotal = $this->cantidad*$costosel->valor;

      // Verificar existencia de cuenta
      if(!empty($this->idcuenta))
      {

         // Insertar detalle de cuenta
         DB::table('pagodetacuenta')
         ->insert([
            'cuenta_id'    => $this->idcuenta,
            'pagope_id'    => $costosel->pago_id,
            'cantidad'     => $this->cantidad,
            'vr_unitario'  => $costosel->valor,
            'vr_total'     => $vrtotal,
            'clase'        => 0,
         ]);

         // Totalizar cuenta de cobro
         $totactual = Cuenta::where('id', $this->idcuenta)
                              ->select('valor')
                              ->first();
         // nuevo valor
         $totalnue = $totactual->valor+$vrtotal;

         // Actualizar Valor
         Cuenta::where('id', $this->idcuenta)
               ->update([
                  'valor'  => $totalnue,
               ]);
      }else{
         // Crear cuenta
         $cuenta = Cuenta::create([
            'genero'       => Auth::user()->id,
            'operador_id'  => $this->operador,
            'valor'        => $vrtotal,
            'fecha'        => $now,
         ]);

         $this->idcuenta = $cuenta->id;

         // Insertar detalle de cuenta
         DB::table('pagodetacuenta')
            ->insert([
               'cuenta_id'    => $this->idcuenta,
               'pagope_id'    => $costosel->pago_id,
               'cantidad'     => $this->cantidad,
               'vr_unitario'  => $costosel->valor,
               'vr_total'     => $vrtotal,
               'clase'        => 0,
            ]);
      }

      $this->cantidad = "";
   }

   // Eliminar item de la cuenta
   public function eliminaitem($id)
   {
      // Seleccionar producto
      $productoid = DB::table('pagodetacuenta')
                        ->where('id', $id)
                        ->select('producto_id', 'vr_total')
                        ->first();

      $total = $this->cuentabase()->valor - $productoid->vr_total;



      // Desmarcar productos
      DB::table('dilioperadors')
         ->where('cuentacobro', $this->idcuenta)
         ->where('id', $productoid->producto_id)
         ->update([
            'cuentacobro'  => Null,
         ]);

      // Actualizar cuenta
      Cuenta::where('id', $this->idcuenta)
            ->update([
               'valor'  => $total,
            ]);

      // Eliminar item
      DB::table('pagodetacuenta')
         ->where('id', $id)
         ->delete();

      // Recargar datos
      $this->seleccionados();
   }

   // Elimina la cuenta
   public function eliminarcuenta()
   {
      // Desmarcar productos en el detalle de factura
      DB::table('dilioperadors')
      ->where('cuentacobro', $this->idcuenta)
      ->update([
         'cuentacobro'  => Null,
      ]);

      // Eliminar detalles
      DB::table('pagodetacuenta')
         ->where('cuenta_id', $this->idcuenta)
         ->delete();

      // Eliminar cuenta
      Cuenta::where('id', $this->idcuenta)
            ->delete();

      $this->reset();

      // Cambiar de operador
      session()->flash('periodo', 'Se elimino la cuenta de cobro');
   }

   // Selecciona Cuenta
   private function cuentabase()
   {
      if(!empty($this->idcuenta))
      {
         return Cuenta::join('users', 'users.id', '=', 'cuentas.operador_id')
         ->where('cuentas.id', $this->idcuenta)
         ->select('users.name', 'cuentas.id', 'cuentas.fecha', 'cuentas.valor', 'cuentas.observaciones', 'cuentas.estado')
         ->first();
      }
   }

   // Selecciona detalles
   private function cuentadetalles()
   {
      if(!empty($this->idcuenta))
      {
         return DB::table('pagodetacuenta')
         ->join('pagoperador', 'pagoperador.id', '=', 'pagodetacuenta.pagope_id')         
         ->where('pagodetacuenta.cuenta_id', $this->idcuenta)
         ->select('pagodetacuenta.id', 'pagodetacuenta.cantidad', 'pagodetacuenta.vr_unitario', 'pagodetacuenta.vr_total', 'pagoperador.cargo', 'pagoperador.tipo' )
         ->get();
      }
   }


   // Actualizar observaciones
   public function insertaobervaciones()
   {
      if(!empty($this->observaciones))
      {
         $now = Carbon::now();

         $observactual = Cuenta::where('id', $this->idcuenta)
                                 ->select('observaciones')
                                 ->first();

         $observanue= "---- ".$now." ".Auth::user()->name." ".$this->observaciones."---- ".$observactual->observaciones;

         Cuenta::where('id', $this->idcuenta)
                  ->update([
                     'observaciones'   => $observanue,
                  ]);

         $this->observaciones = "";

                  session()->flash('observacionescambia', 'Han sido actualizadas las observaciones.');
      }
   }

   // Seleccionar numero de cuenta que sigue
   public function finalizacuenta()
   {
      if($this->puerta==3)
      {
         // Fecha de hoy
         $now = Carbon::now();

         $seleccionanum = Cuenta::max('numero');
         $mayor = $seleccionanum+1;

         // Cerrar cuenta
         Cuenta::where('id', $this->idcuenta)
               ->update([
                  'numero' => $mayor,
                  'estado' => 2,
               ]);

         // Crea obligación
         $operador = User::where('id', $this->operador)->select('name', 'username')->first();
         $nombre = $now." cuenta cobro ".$operador->name; 

         $cuentactual = Cuenta::where('id', $this->idcuenta)->select('valor')->first();

         $observa = "---".$now." ".Auth::user()->name." creo la obligación. --- ";
         
         $obli = Obligacione::create([
            'nombre'            => $nombre,
            'identificacion'    => $operador->username,
            'banco'             => $this->banco,
            'cuenta'            => $this->cuentapago,
            'tipocuenta'        => $this->tipocuentapago,
            'tipo'              => 1,
            'numerotipo'        => $mayor,
            'fecha'             => $now,
            'pago'              => $cuentactual->valor,
            'observaciones'     => $observa,
            'user_id'           => Auth::user()->id,
        ]);

   

         session()->flash('periodo', 'Se ha generado la cuenta de cobro N°: '.$mayor.' y la obligación N°: '.$obli->id.
                           ' para el operador: '.$operador->name);
         $this->numerocuenta  = $mayor;
         $this->cambiaoperador();


      }
   }

   public function render()
   {
      return view('livewire.facturacion.cuentacobro', [
         'operadores'         => $this->operadores(),
         'opeseleccionado'    => $this->opeseleccionado(),
         'cuentaproceso'      => $this->cuentaproceso(),
         'seleccionados'      => $this->seleccionados(),
         'esquemavig'         => $this->esquemavig(),
         'costos'             => $this->costos(),
         'cuentabase'         => $this->cuentabase(),
         'cuentadetalles'     => $this->cuentadetalles(),
         'datpago'            => $this->datopago(),
      ]);
   }
}
