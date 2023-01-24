<?php

namespace App\Http\Livewire\Facturacion;

use App\Cargo;
use App\Correspondencia;
use App\Diligencia;
use App\Dilioperador;
use App\Empresa;
use App\EmpresaUser;
use App\Factura;
use App\Lp;
use App\Producto;
use App\Recorrido;
use App\Sucursale;
use App\User;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;


class Generafactura extends Component
{
   public $nit;
   public $nite;
   public $sucursal;
   public $fechafac;
   public $fechacam;
   public $fechacamven;
   public $observaciones;
   public $lp;
   public $lpsel='';
   public $tipo;
   public $opesel;
   public $cantidad;
   public $cant;
   public $totalitem;
   public $idfactura;
   public $puerta;

   public $fechadesde;
   public $fechahasta;
   public $serviciocrt=1;
   public $productos;
   public $numerofactura;
   public $final=0;
   public $cargosel=[];

   public $ordena='id';
   public $ordenado='ASC';

   // Paginación
   use WithPagination;


   // Muestra el listado de de facturas en proceso
   private function factuproces()
   {
      if(empty($this->nit))
      {
         return Factura::join('empresas', 'empresas.id', '=', 'facturas.cliente_id')
                        ->join('sucursales', 'sucursales.id', '=', 'facturas.sucursal_id')
                        ->select('empresas.nombre as empresa', 'sucursales.nombre', 'facturas.id')
                        ->where('facturas.estado', 1)
                        ->get();
      }
   }

   //Activa facura seleccionada en proceso
   public function seleccionafactura()
   {
      $facturaelegida = Factura::where('id', $this->nite)
                              ->first();

      $this->nit = $facturaelegida->cliente_id;
      $this->fechafac = $facturaelegida->fecha;
      $this->sucursal = $facturaelegida->sucursal_id;
      $this->idfactura = $facturaelegida->id;
   }

   // Cliente seleccionado
   private function clieselec()
   {
      if(!empty($this->nit)){
         return Empresa::where('id', $this->nit)
                     ->select('nit', 'nombre', 'direccion', 'telefono', 'email', 'logo')
                     ->first();
      }
   }

   // Listado de sucursales.
   private function sucursales()
   {
      if(!empty($this->nit)){
         return Sucursale::where('empresa_id', $this->nit)
                        ->where('estado', 1)
                        ->select('id', 'nombre')
                        ->orderBy('nombre', 'ASC')
                        ->get();
      }
   }

   // Seleccionar lista de precios.
   private function lps()
   {
      if(!empty($this->fechafac))
      {
         $lpeleg = Lp::join('lpclies', 'lpclies.lp', '=', 'lps.id')
                  ->where('lpclies.cliente', $this->nit)
                  ->where('lps.estado', 2)
                  ->whereDate('lps.inicio', '<=', $this->fechafac)
                  ->whereDate('lps.fin', '>=', $this->fechafac)
                  ->select('lps.lista', 'lps.id')
                  ->first();

         if($lpeleg){
            $this->lp = $lpeleg->id;
            $this->lpsel = 1;
            return $lpeleg;
         } else {
            $this->lpsel='';
         }


      }
   }

   // Seleccionar productos de a lista de precios.
   private function lppros()
   {
      if(!empty($this->lp))
      {
         return Producto::join('lppros', 'lppros.producto', '=', 'productos.id')
                        ->where('lppros.lp', $this->lp)
                        ->where('lppros.estado', 1)
                        ->select('productos.descripcion','productos.tipo','lppros.id',
                                 'lppros.alias', 'lppros.valor')
                        ->orderBy('lppros.alias', 'ASC')
                        ->get();
      }
   }

   // Muestra los operadores asignados a esta empresa
   private function operadores()
   {
      if(!empty($this->lp))
      {
         return EmpresaUser::where('empresa_id', $this->nit)
                           ->where('estado', 1)
                           ->whereNotIn('role_id', [4,6,7])
                           ->select('user_id', 'name')
                           ->orderBy('name', 'ASC')
                           ->get();
      }
   }

   // Tipo de producto a facturar
   public function tipofac($id)
   {
      // Resetear paginación
      $this->resetPage();

      // Cambiar tipo de producto
      $this->tipo = $id;
   }

   // Incluye productos a la factura
   public function incluye($id)
   {
      if(!empty($this->cantidad))
      {

         // ojo agregar impuestos descuentos y demás
         $detalles=DB::table('lppros')
                     ->where('id', $id)
                     ->first();
         $total = $this->cantidad*$detalles->valor;


         if(!empty($this->idfactura))
         {
            DB::table('detafacturas')
               ->insert([
                  'factura_id'   => $this->idfactura,
                  'producto_id'  => $id,
                  'operador_id'  => $this->opesel,
                  'cantidad'     => $this->cantidad,
                  'vr_unitario'  => $detalles->valor,
                  'vr_impuesto'  => '0',
                  'vr_total'     => $total,
               ]);

            // Totalizar factura
            $totales = DB::table('detafacturas')
                           ->where('factura_id', $this->idfactura)
                           ->get();
            // Actualizar factura
            Factura::where('id', $this->idfactura)
                     ->update([
                        'valor'     => $totales->sum('vr_total'),
                        'impuesto'  => $totales->sum('vr_impuesto'),
                     ]);
         }else{

            // Crear la factura
            $nuevafactura = Factura::create([
                        'genero'       => Auth::user()->id,
                        'cliente_id'   => $this->nit,
                        'sucursal_id'  => $this->sucursal,
                        'valor'        => $total,
                        'impuesto'     => '0',
                        'fecha'        => $this->fechafac,
                        'fechavence'   => $this->fechafac,
                     ]);

            $this->idfactura = $nuevafactura->id;

            // Cargar detalle
            DB::table('detafacturas')
               ->insert([
                  'factura_id'   => $this->idfactura,
                  'producto_id'  => $id,
                  'operador_id'  => $this->opesel,
                  'cantidad'     => $this->cantidad,
                  'vr_unitario'  => $detalles->valor,
                  'vr_impuesto'  => '0',
                  'vr_total'     => $total,
               ]);

         };
      }
      $this->cantidad='';
   }

   // Base de la factura en proceso
   private function basicosfactura()
   {
      if(!empty($this->idfactura))
      {
         return Factura::where('id', $this->idfactura)
                        ->first();
      }
   }
   // ordena el listado de productos cargados a la factura
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

   // Productos asignados a esta factura
   private function detallesfactura()
   {
      if(!empty($this->idfactura))
      {
         return DB::table('detafacturas')
                  ->join('lppros', 'lppros.id', '=', 'detafacturas.producto_id')
                  ->join('users', 'users.id', '=', 'detafacturas.operador_id')
                  ->select('detafacturas.id', 'detafacturas.cantidad', 'detafacturas.vr_unitario', 'detafacturas.recorrido_id',
                           'detafacturas.vr_total', 'users.name', 'lppros.alias')
                  ->where('detafacturas.factura_id', $this->idfactura)
                  ->orderBy($this->ordena, $this->ordenado)
                  ->paginate(10);
      }
   }

   // Elimina producto de la factura
   public function elimproduc($id)
   {
      // Seleccionar linea
      $recorrido = DB::table('detafacturas')
         ->where('id', $id)
         ->select('recorrido_id', 'diligencia_id')
         ->first();

      // Actualizar registro de factura
      if($recorrido->recorrido_id>0)
      {

         Recorrido::where('id', $recorrido->recorrido_id)
                  ->update([
                     'idfactura' => Null,
                  ]);
      }

      if($recorrido->diligencia_id>0)
      {
         Diligencia::where('id', $recorrido->diligencia_id)
                  ->update([
                     'estado' => 5,
                  ]);
      }

      // Eliminar producto
      DB::table('detafacturas')
         ->where('id', $id)
         ->delete();

      // Totalizar factura
      $totales = DB::table('detafacturas')
      ->where('factura_id', $this->idfactura)
      ->get();

      // Actualizar factura
      Factura::where('id', $this->idfactura)
         ->update([
            'valor'     => $totales->sum('vr_total'),
            'impuesto'  => $totales->sum('vr_impuesto'),
         ]);

      // Evitar la facturación
      if($this->tipo==4)
      {
         $this->tipo='';
      }

   }

   // Mostrar Mensaje
   public function abrir()
   {
      $this->puerta = 1;
   }

   // Cerrar Mensaje
   public function cerrar()
   {
      $this->puerta = '';
   }

   // Elimina factura actual
   public function eliminarfactura()
   {
       // Seleccionar los detalles
       $recorridos = DB::table('detafacturas')
       ->where('factura_id', $this->idfactura)
       ->select('recorrido_id')
       ->get(); 

      foreach($recorridos as $recorrido)
      {
         if($recorrido->recorrido_id>0)
            {

               Recorrido::where('id', $recorrido->recorrido_id)
                        ->update([
                           'idfactura' => Null,
                        ]);
            }         
      }

      // Actualizar diligencias
      Diligencia::where('estado', $this->idfactura)
                        ->update([
                           'estado' => 5,
                        ]);

      

      // Eliminar Factura
      Factura::where('id', $this->idfactura)
            ->delete();     


      // Eliminar detalles
      DB::table('detafacturas')
         ->where('factura_id', '=', $this->idfactura)
         ->delete();

      // Liberar Variables
      $this->nit= '';
      $this->nite= '';
      $this->sucursal= '';
      $this->fechafac= '';
      $this->lp= '';
      $this->lpsel='';
      $this->tipo= '';
      $this->opesel= '';
      $this->cantidad= '';
      $this->totalitem= '';
      $this->idfactura= '';
      $this->puerta= '';
      $this->productos='';

            session()->flash('messagelim', ' La factura fue eliminada correctamente.');
   }

   // Cambia fecha de factura
   public function fechacambia($id)
   {
      if(!empty($this->fechacam))
      {
         Factura::where('id', $id)
            ->update([
               'fecha' => $this->fechacam,
            ]);

            session()->flash('cambia', 'Se actualizo la fecha de la factura a: '.$this->fechacam);

            $this->fechacam='';
      }
   }

   // Cambia fecha de vencimiento
   public function fechavencecambia($id)
   {
      if(!empty($this->fechacamven))
      {
         Factura::where('id', $id)
            ->update([
               'fechavence' => $this->fechacamven,
            ]);

            session()->flash('cambiavence', 'Se actualizo la fecha de vencimiento a: '.$this->fechacamven);

            $this->fechacamven='';
      }
   }

   // Inserta Observaciones
   public function insertaobervaciones($id)
   {
      if(!empty($this->observaciones))
      {
         $observa = Factura::where('id', $id)
                           ->select('observacionesfactura')
                           ->first();
         $observac=$observa->observacionesfactura;
         $cambiaobser=$this->observaciones." - ".$observac;

         Factura::where('id', $id)
            ->update([
               'observacionesfactura'  => $cambiaobser,
               'genero'                => Auth::user()->id,
            ]);

            session()->flash('observacionescambia', 'Se registraron observaciones a la factura.');

            $this->observaciones='';
      }
   }

   // Modificar Cantidades
   public function modcan($id)
   {
      if($this->cant>0)
      {
         // Seleccionar movimiento
         $actual=DB::table('detafacturas')
                  ->where('id', $id)
                  ->select('vr_unitario')
                  ->first();

         // Actualizar
         $nuevototal = $this->cant*$actual->vr_unitario;

         DB::table('detafacturas')
            ->where('id', $id)
            ->update([
               'cantidad'  => $this->cant,
               'vr_total'  => $nuevototal,
            ]);

         // Totalizar factura
         $totales = DB::table('detafacturas')
         ->where('factura_id', $this->idfactura)
         ->get();
         // Actualizar factura
         Factura::where('id', $this->idfactura)
            ->update([
               'valor'     => $totales->sum('vr_total'),
               'impuesto'  => $totales->sum('vr_impuesto'),
            ]);

         $this->cant='';
      }
   }

   // Seleccionar movimientos en un período
   private function seleccionados()
   {
      if(!empty($this->fechadesde))
      {
         if($this->fechadesde<=$this->fechahasta)
         {
            $this->serviciocrt=2;
            
            return Correspondencia::join('recorridos', 'recorridos.correspondencia_id', '=', 'correspondencias.id')
                                    ->select(
                                       'correspondencias.nombresede', 'correspondencias.nombreubicacion',
                                       'correspondencias.descripcion', 'correspondencias.detalle', 'recorridos.entregado',
                                       'correspondencias.created_at', 'correspondencias.observaciones','recorridos.id'
                                       )
                                    ->whereNull('recorridos.idfactura')
                                    ->whereNotNull('recorridos.entregado')
                                    ->whereDate('correspondencias.created_at', '>=', $this->fechadesde)
                                    ->whereDate('correspondencias.created_at', '<=', $this->fechahasta)
                                    ->where('correspondencias.empresa_id', $this->nit)
                                    ->orderBy('correspondencias.created_at', 'ASC')
                                    ->orderBy('correspondencias.detalle', 'ASC')
                                    ->paginate(5);
            
            
            
         } else {
            $this->serviciocrt=1;
            session()->flash('periodo', 'Revise las fechas');
         }
      }

      if($this->tipo==5)
      {
         return Diligencia::where('empresa_id', $this->nit)
                           ->where('estado', 5)
                           ->orderBy('fecha', 'ASC')
                           ->paginate(20);
      }
   }

   // Incluir desde el select
   public function seleccionaproducto($id)
   {
      // Selecciona producto
      $producto = DB::table('lppros')
                     ->where('id', $this->productos)
                     ->select('valor')
                     ->first();

      // Selecciona operador
      $diligencia = Recorrido::where('id', $id)
                              ->select('operador')
                              ->first();
      // Verificar si el producto no es facturable
      if($this->productos==0){
         // Actualizar registro de factura
         Recorrido::where('id', $id)
         ->update([
            'idfactura' => $this->idfactura,
         ]);
      }else{
         // Registrar Producto
         if(!empty($this->idfactura))
         {
            DB::table('detafacturas')
                  ->insert([
                     'factura_id'   => $this->idfactura,
                     'producto_id'  => $this->productos,
                     'operador_id'  => $diligencia->operador,
                     'cantidad'     => 1,
                     'vr_unitario'  => $producto->valor,
                     'vr_impuesto'  => '0',
                     'vr_total'     => $producto->valor,
                     'recorrido_id' => $id,
                  ]);

            // Totalizar factura
            $totales = DB::table('detafacturas')
                           ->where('factura_id', $this->idfactura)
                           ->get();
            // Actualizar factura
            Factura::where('id', $this->idfactura)
                     ->update([
                        'valor'     => $totales->sum('vr_total'),
                        'impuesto'  => $totales->sum('vr_impuesto'),
                     ]);

            // Actualizar registro de factura
            Recorrido::where('id', $id)
                     ->update([
                        'idfactura' => $this->idfactura,
                     ]);
         } else{

            // Crear la factura
            $nuevafactura = Factura::create([
                        'genero'       => Auth::user()->id,
                        'cliente_id'   => $this->nit,
                        'sucursal_id'  => $this->sucursal,
                        'valor'        => $producto->valor,
                        'impuesto'     => '0',
                        'fecha'        => $this->fechafac,
                        'fechavence'   => $this->fechafac,
                     ]);

            $this->idfactura = $nuevafactura->id;

            DB::table('detafacturas')
                  ->insert([
                     'factura_id'   => $this->idfactura,
                     'producto_id'  => $this->productos,
                     'operador_id'  => $diligencia->operador,
                     'cantidad'     => 1,
                     'vr_unitario'  => $producto->valor,
                     'vr_impuesto'  => '0',
                     'vr_total'     => $producto->valor,
                     'recorrido_id' => $id,
                  ]);

            // Actualizar registro de factura
            Recorrido::where('id', $id)
            ->update([
            'idfactura' => $this->idfactura,
            ]);

         };
      };
   }

   // Incluir servicios a la factura
   public function incl($id)
   {
      // Selecciona producto
      $producto = DB::table('lppros')
                     ->where('id', $this->productos)
                     ->select('valor')
                     ->first();

      // Selecciona operador
      $diligencia = Recorrido::where('id', $id)
                              ->select('operador')
                              ->first();

      if(!empty($this->idfactura))
      {
         // Registrar Producto
         DB::table('detafacturas')
         ->insert([
            'factura_id'   => $this->idfactura,
            'producto_id'  => $this->productos,
            'operador_id'  => $diligencia->operador,
            'cantidad'     => 1,
            'vr_unitario'  => $producto->valor,
            'vr_impuesto'  => '0',
            'vr_total'     => $producto->valor,
            'recorrido_id' => $id,
         ]);

         // Totalizar factura
         $totales = DB::table('detafacturas')
                     ->where('factura_id', $this->idfactura)
                     ->get();
         // Actualizar factura
         Factura::where('id', $this->idfactura)
               ->update([
                  'valor'     => $totales->sum('vr_total'),
                  'impuesto'  => $totales->sum('vr_impuesto'),
               ]);

         // Actualizar registro de factura
         Recorrido::where('id', $id)
         ->update([
            'idfactura' => $this->idfactura,
         ]);
      }else{
         // Crear la factura
         $nuevafactura = Factura::create([
            'genero'       => Auth::user()->id,
            'cliente_id'   => $this->nit,
            'sucursal_id'  => $this->sucursal,
            'valor'        => $producto->valor,
            'impuesto'     => '0',
            'fecha'        => $this->fechafac,
            'fechavence'   => $this->fechafac,
         ]);

         $this->idfactura = $nuevafactura->id;

         DB::table('detafacturas')
         ->insert([
         'factura_id'   => $this->idfactura,
         'producto_id'  => $this->productos,
         'operador_id'  => $diligencia->operador,
         'cantidad'     => 1,
         'vr_unitario'  => $producto->valor,
         'vr_impuesto'  => '0',
         'vr_total'     => $producto->valor,
         'recorrido_id' => $id,
         ]);

         // Actualizar registro de factura
         Recorrido::where('id', $id)
         ->update([
         'idfactura' => $this->idfactura,
         ]);
      }

   }

   // Incluir diligencias a la factura
   public function selecdiligencia($id, $guias)
   {  

      // Selecciona operador
      $diligencia = Dilioperador::where('diligencia_id', $id)
                              ->where('estado', 2) 
                              ->select('usuario_id')
                              ->first();

      // Selecciona producto    
      if($this->productos==0){
         $guias = 0;
         $valordb = 0;
      } else {           
         $producto = DB::table('lppros')
                  ->where('id', $this->productos)
                  ->select('valor')
                  ->first();

         $valordb = $producto->valor;
      }

      $valor = $guias*$valordb;

      // Verificar si el producto no es facturable
      if($this->productos==0){
         // Actualizar registro de factura
         Diligencia::where('id', $id)
         ->update([
            'estado' => $this->idfactura,
         ]);
      }else{
         // Registrar Producto
         if(!empty($this->idfactura))
         {
            DB::table('detafacturas')
                  ->insert([
                     'factura_id'   => $this->idfactura,
                     'producto_id'  => $this->productos,
                     'operador_id'  => $diligencia->usuario_id,
                     'cantidad'     => $guias,
                     'vr_unitario'  => $producto->valor,
                     'vr_impuesto'  => '0',
                     'vr_total'     => $valor,
                     'diligencia_id' => $id,
                  ]);

            // Totalizar factura
            $totales = DB::table('detafacturas')
                           ->where('factura_id', $this->idfactura)
                           ->get();

            // Actualizar factura
            Factura::where('id', $this->idfactura)
                     ->update([
                        'valor'     => $totales->sum('vr_total'),
                        'impuesto'  => $totales->sum('vr_impuesto'),
                     ]);

            // Actualizar registro de factura
            Diligencia::where('id', $id)
                     ->update([
                        'estado' => $this->idfactura,
                     ]);
         } else {

            // Crear la factura
            $nuevafactura = Factura::create([
                        'genero'       => Auth::user()->id,
                        'cliente_id'   => $this->nit,
                        'sucursal_id'  => $this->sucursal,
                        'valor'        => $valor,
                        'impuesto'     => '0',
                        'fecha'        => $this->fechafac,
                        'fechavence'   => $this->fechafac,
                     ]);

            $this->idfactura = $nuevafactura->id;

            DB::table('detafacturas')
                  ->insert([
                     'factura_id'   => $this->idfactura,
                     'producto_id'  => $this->productos,
                     'operador_id'  => $diligencia->usuario_id,
                     'cantidad'     => $guias,
                     'vr_unitario'  => $producto->valor,
                     'vr_impuesto'  => '0',
                     'vr_total'     => $valor,
                     'diligencia_id' => $id,
                  ]);

            // Actualizar registro de factura
            Diligencia::where('id', $id)
            ->update([
               'estado' => $this->idfactura,
            ]);

         };
      };
   }  

   // Mostrar Prefactura
   private function prefactura()
   {
      if($this->tipo==3 OR $this->final==1)
      {
         return DB::table('detafacturas')
                  ->join('lppros', 'lppros.id', '=', 'detafacturas.producto_id')
                  ->select('detafacturas.producto_id',
                           DB::raw('SUM(detafacturas.cantidad) as cantidad'),
                           DB::raw('SUM(detafacturas.vr_total) as total'),
                           'detafacturas.vr_unitario', 'lppros.alias')
                  ->where('detafacturas.factura_id', $this->idfactura)
                  ->groupBy('detafacturas.producto_id', 'detafacturas.vr_unitario', 'lppros.alias')
                  ->orderBy('lppros.alias', 'ASC')
                  ->get();
      }
   }

   //Identifica N° de Factura
   private function numfactura()
   {
      if($this->tipo==4)
      {
         $numeromax = Factura::max('numero');
         $numeropropuesto = $numeromax+1;

         return $numeropropuesto;
      }
   }

   // Seleccionar cargos a la factura
   private function cargos()
   {
      if($this->tipo==4)
      {
         return Cargo::where('producto', 0)
         ->where('estado', 1)
         ->select('id', 'descripcion', 'cargo')
         ->orderBy('tipo', 'ASC')
         ->orderBy('cargo', 'ASC')
         ->get();
      }
   }

   // Finalizar Factura
   public function submit()
   {
      $this->validate([
         "numerofactura"     => 'required',
      ]);
      // Verificar el uso del número
      $usado=Factura::where('numero', $this->numerofactura)
                     ->count('numero');

      if($usado==0)
      {
         // Cargar impuestos y descuentos

         foreach ($this->cargosel as $selcargo)
         {
            DB::table('facturacargos')
            ->insert([
               'factura_id'=>$this->idfactura,
               'cargo_id'  =>$selcargo,
            ]);
         }

         // Finalizar factura
         Factura::where('id', $this->idfactura)
         ->update([
            'numero'=>$this->numerofactura,
            'estado'=>2,
         ]);

         // Finalizar detalles
         DB::table('detafacturas')
            ->where('factura_id', $this->idfactura)
            ->update([
               'estado'=>2,
            ]);


         session()->flash('messagelim', 'Se ha finalizado correctamente la factura N°: '.$this->numerofactura);

         $this->nit           = "";
         $this->sucursal      = "";
         $this->final         =  1;
      }else{

         session()->flash('messagerepe', 'El N°: '.$this->numerofactura.', esta en uso debe registrar otro ');
         $this->numerofactura = "";
      }
   }

   public function render()
   {

      return view('livewire.facturacion.generafactura', [
         'clientes'  => Empresa::where('estado', 1)
                                 ->where('id', '!=', 1)
                                 ->select('id', 'nombre')
                                 ->orderBy('nombre', 'ASC')
                                 ->get(),
         'factuproces'  => $this->factuproces(),
         'sucursales'   => $this->sucursales(),
         'clieselec'   => $this->clieselec(),
         'lps'   => $this->lps(),
         'lppros'   => $this->lppros(),
         'operadores'   => $this->operadores(),
         'basicosfactura'   => $this->basicosfactura(),
         'detallesfactura'   => $this->detallesfactura(),
         'seleccionados'   => $this->seleccionados(),
         'prefactura'   => $this->prefactura(),
         'numfactura'   => $this->numfactura(),
         'cargos'   => $this->cargos(),
      ]);
   }
}
