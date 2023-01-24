<?php

use App\Area;
use App\Ciudade;
use App\Empresa;
use App\Incapacidad;
use App\Sucursale;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// grupos
Route::middleware(['auth'])->group(function(){

   // VISTAS GENERALES
   Route::Resource ('user', 'UserController')->names('user');
   Route::Resource('/role', 'RoleController')->names('role');
   Route::Resource('/empresa', 'EmpresaController')->names('empresa');
   Route::get('/listaciudad', 'CiudadeController@listaciudad')->name('listaciudad');
   Route::Resource('/sucursale', 'SucursaleController')->names('sucursale');
   Route::get('/listasucursal', 'SucursaleController@getSucursales')->name('listasucursal');
   Route::Resource('/area', 'AreaController')->names('area');
   Route::get('/listarea', 'AreaController@getAreas')->name('listarea');
   Route::Resource('/adicionals', 'AdicionalController')->names('adicionals');
   Route::post('fotousuario', 'AdicionalController@foto')->name('fotousuario');
   Route::Resource('/soporte', 'SoporteController')->names('soporte');
   Route::Resource('/empresauser', 'EmpresaUserController')->names('empresauser');
   Route::post('empresarifa', 'EmpresaUserController@rifa')->name('empresarifa');
   Route::post('empresactualiza', 'EmpresaUserController@actualizar')->name('empresactualiza');
   Route::Resource('/salario', 'SalarioController')->names('salario');
   Route::Resource('/dotacions', 'DotacionController')->names('dotacions');
   Route::Resource('/dotaentrega', 'DotaentregaController')->names('dotaentrega');
   Route::Resource('/vacacione', 'VacacioneController')->names('vacacione');
   Route::Resource('incapacidad', 'IncapacidadController')->names('incapacidad');
   Route::Resource('/certificado', 'CertificadoController')->names('certificado');
   Route::Resource('corres', 'CorrespondenciaController')->names('corres');
   Route::post('importarcorres', 'CorrespondenciaController@importar')->name('importarcorres');
   Route::post('cargafoto', 'CorrespondenciaController@foto')->name('cargafoto');
   Route::Resource('/recorrido', 'RecorridoController')->names('recorrido');
   Route::Resource('/clases', 'TipoEnvioController')->names('clases');
   Route::Resource('/frecuente', 'FrecuenteController')->names('frecuente');
   Route::get('/miashoy', 'api\ConsultasController@miashoy')->name('miashoy');
   Route::get('/mias', 'api\ConsultasController@mias')->name('mias');
   Route::get('/parami', 'api\ConsultasController@parami')->name('parami');
   Route::get('/nuestras', 'api\ConsultasController@nuestras')->name('nuestras');
   Route::get('/paranosotros', 'api\ConsultasController@paranosotros')->name('paranosotros');
   Route::get('/destinatarios', 'api\ConsultasController@destinatarios')->name('destinatarios');
   Route::get('/remitente', 'api\ConsultasController@remitente')->name('remitente');
   Route::get('/frecuentes', 'api\ConsultasController@frecuentes')->name('frecuentes');
   Route::get('/eliminar', 'api\ConsultasController@eliminar')->name('eliminar');
   Route::get('/todos', 'api\ConsultasController@todos')->name('todos');


   // Rifas
   Route::get('/gestionrifa', function () {  return view('rifa.gestion'); })->name('gestionrifa');
   Route::get('/ventarifa', function () {  return view('rifa.venta'); })->name('ventarifa');

   //usuarios
   Route::get('/userindex', function () {  return view('user.index'); });

   //Indicadores
   Route::get('/paramefes', function () {  return view('parametros'); });
   Route::get('/inditiempos', function () {  return view('correspondencia.inditiempos'); })->name('inditiempos');

   //correspondencia
   Route::get('/micorrespondencia', function () {  return view('correspondencia.correspondencia'); });
   Route::get('/misenvios', function () {  return view('correspondencia.misenvios'); });
   Route::get('/misentregas', function () {  return view('correspondencia.misentregas'); });
   Route::get('/gestioncorres', function () {  return view('correspondencia.index'); });
   Route::get('/ciudadfuera', function () {  return view('correspondencia.fuera'); });
   Route::get('/recorridorden', function () {  return view('correspondencia.recorridorden'); });
   Route::get('/dilitengo', function () {  return view('correspondencia.dilitengo'); })->name('dilitengo');
   Route::get('/gestplanilla', function () {  return view('correspondencia.gestplanilla'); })->name('gestplanilla');
   Route::get('/parametros', function () {  return view('correspondencia.parametros'); })->name('parametros');
   Route::get('/soliabierta', function () {  return view('correspondencia.soliabierta'); })->name('soliabierta');

   // Diligencias
   //Route::get('/diligencias', function () {  return view('diligencias.diligencias'); })->name('diligencias');
   Route::get('/lasmias', function () {  return view('diligencias.diligencias'); })->name('lasmias');
   Route::get('/gestiondiligencia', function () {  return view('diligencias.gestiondiligencia'); })->name('gestiondiligencia');
   Route::get('/historial', function () {  return view('diligencias.historial'); })->name('historial');
   Route::get('/historialadmin', function () {  return view('diligencias.historialadmin'); })->name('historialadmin');
   Route::get('/mensajerodili', function () {  return view('diligencias.mensajerodili'); })->name('mensajerodili');


   //Facturación
   Route::get('/paramefac', function () {  return view('facturacion.parametros'); })->name('paramefac');
   Route::get('/factura', function () {  return view('facturacion.factura'); })->name('factura');
   Route::get('/prepago', function () {  return view('facturacion.prepago'); })->name('prepago');
   Route::get('/listafactura', function () {  return view('facturacion.listafactura'); })->name('listafactura');
   Route::get('/cuentacobro', function () {  return view('facturacion.cuentacobro'); })->name('cuentacobro');
   Route::get('/listacuco', function () {  return view('facturacion.listacuco'); })->name('listacuco');
   Route::post('cargazip', 'FacturaController@zip')->name('cargazip');

   // Financiero
   Route::get('/financiero', 'FinancieroController@lista')->name('financiero');
   Route::get('/efectivo', 'FinancieroController@efectivo')->name('efectivo');
   Route::get('/movimiento', 'FinancieroController@movimiento')->name('movimiento');
   Route::get('/obligaciones', 'FinancieroController@obligaciones')->name('obligaciones');
   Route::get('/obligahist', 'FinancieroController@obligahist')->name('obligahist');

   // Humana
   Route::get('/paramehum', function () {  return view('humana.paramehum'); })->name('paramehum');


   //PDF
   Route::get('planillapdf/{id}', 'PdfController@planillapdf')->name('planillapdf');
   Route::get('facturapdf/{id}', 'PdfController@facturapdf')->name('facturapdf');

   //EXCELL
   Route::post('inditiempoxls', 'XlsController@inditiempoxls')->name('inditiempoxls');

   // Base de datos
   Route::get('/navegacion', function () {

      $usuario = Auth::user();


      $empresactual = Empresa::where('id', $usuario->empresa)->first();

      // return  compact('empresactual');
      return $empresactual;
   });

   Route::get('/sucursal', function () {

      Gate::authorize('haveaccess','sucursale.create');

      $ciudades =  Ciudade::orderBy('ciudad','Asc')
                  ->select('id','ciudad')
                  ->get();

      $idemp = Auth::user()->empresa;

      $sucursales = Sucursale::where('empresa_id', $idemp)
                     ->orderBy('nombre', 'ASC')
                     ->paginate(20);

      return view('sucursal.index', compact('sucursales', 'ciudades'));
   })->name('sucursal');


   Route::get('/areas', function () {

      $idemp = Auth::user()->empresa;

      $areas = Area::where('empresa_id', $idemp)
                     ->orderBy('area', 'ASC')
                     ->paginate(20);

      return view('area.index', compact('areas'));
   })->name('areas');




});

Route::get('/test', function () {

   $user = User::find(1);

   $adicionals = $user->adicionals()->get();


   return compact('user', 'adicionals');

});


