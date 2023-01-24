<?php

use App\Models\Permission as ModelsPermission;
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      //Superadministrador
      Permission::create([
         'name'          => 'superadministrador',
         'slug'          => 'superadministrador',
         'description'   => 'modifica la mayoria de todos los modulos',
      ]);

      //Users
      Permission::create([
         'name'          => 'Modificar Cualquier Usuario',
         'slug'          => 'modificatodo',
         'description'   => 'Puede modificar cualquier usuario que este dentro de todo el sistema, sin importar a que empresa pertenezca',
      ]);

      Permission::create([
         'name'          => 'Ver listado de usuarios',
         'slug'          => 'userindex',
         'description'   => 'Permite ingresar a la vista donde muestra todos los usuarios del sistema',
      ]);

      Permission::create([
         'name'          => 'Navegar usuarios',
         'slug'          => 'user.index',
         'description'   => 'Lista y navega todos los usuarios del sistema',
      ]);

      Permission::create([
         'name'          => 'Creación de usuarios',
         'slug'          => 'user.create',
         'description'   => 'Podría crear nuevos usuarios en el sistema',
      ]);

      Permission::create([
         'name'          => 'Ver detalle de usuario',
         'slug'          => 'user.show',
         'description'   => 'Ve en detalle cada usuario del sistema',
      ]);

      Permission::create([
         'name'          => 'Edición de usuarios',
         'slug'          => 'user.edit',
         'description'   => 'Podría editar cualquier dato de un usuario del sistema',
      ]);

      Permission::create([
         'name'          => 'Acceso general de los usuarios',
         'slug'          => 'misdatos',
         'description'   => 'Permite editar los datos propios dentro del sistema, generar correspondencia a nombre propio, actualizar información de mi propiedad',
      ]);



      //Roles
      Permission::create([
         'name'          => 'Navegar roles',
         'slug'          => 'role.index',
         'description'   => 'Lista y navega todos los roles del sistema',
      ]);

      Permission::create([
         'name'          => 'Ver detalle de un rol',
         'slug'          => 'role.show',
         'description'   => 'Ve en detalle cada rol del sistema',
      ]);

      Permission::create([
         'name'          => 'Creación de roles',
         'slug'          => 'role.create',
         'description'   => 'Podría crear nuevos roles en el sistema',
      ]);

      Permission::create([
         'name'          => 'Edición de roles',
         'slug'          => 'role.edit',
         'description'   => 'Podría editar cualquier dato de un rol del sistema',
      ]);

      Permission::create([
         'name'          => 'Eliminar roles',
         'slug'          => 'role.destroy',
         'description'   => 'Podría eliminar cualquier rol del sistema',
      ]);

      //Empresas
      Permission::create([
         'name'          => 'Navegar Empresas',
         'slug'          => 'empresa.index',
         'description'   => 'Lista y navega todos las empresas registradas en el sistema',
      ]);

      Permission::create([
         'name'          => 'Actualizar los datos de una empresa',
         'slug'          => 'empresa.update',
         'description'   => 'Actualizar la empresa',
      ]);

      Permission::create([
         'name'          => 'Ver detalle de la empresa',
         'slug'          => 'empresa.edit',
         'description'   => 'Editar la información básica de la empresa',
      ]);

      Permission::create([
         'name'          => 'Creación de Empresas',
         'slug'          => 'empresa.create',
         'description'   => 'Podría crear nuevas empresas en el sistema',
      ]);

      Permission::create([
         'name'          => 'Asignar Empresas',
         'slug'          => 'empresa.asigna',
         'description'   => 'Asigna empresa a los usuarios',
      ]);

      //sucursales
      Permission::create([
         'name'          => 'Navegar Todas las sucursales',
         'slug'          => 'sucursale.index',
         'description'   => 'Lista y navega todos las sucursales de cada empresa registradas en el sistema',
      ]);
      Permission::create([
         'name'          => 'Navegar sucursales',
         'slug'          => 'sucursal',
         'description'   => 'Lista y navega todos las sucursales de la empresa actual',
      ]);

      Permission::create([
         'name'          => 'Actualizar los datos de una sucursal',
         'slug'          => 'sucursale.update',
         'description'   => 'Actualizar la sucursal',
      ]);

      Permission::create([
         'name'          => 'Ver detalle de la sucursal',
         'slug'          => 'sucursale.edit',
         'description'   => 'Editar la información básica de la sucursal',
      ]);

      Permission::create([
         'name'          => 'Creación de sucursales',
         'slug'          => 'sucursale.create',
         'description'   => 'Podría crear nuevos sucursales en el sistema',
      ]);

      //Áreas
      Permission::create([
         'name'          => 'Navegar todas las áreas',
         'slug'          => 'area.index',
         'description'   => 'Lista y navega todos las áreas de cada empresa registradas en el sistema',
      ]);

      Permission::create([
         'name'          => 'Navegar áreas',
         'slug'          => 'areas',
         'description'   => 'Lista y navega todos las áreas de cada empresa registradas en el sistema',
      ]);

      Permission::create([
         'name'          => 'Actualizar los datos de un área',
         'slug'          => 'area.update',
         'description'   => 'Actualizar el área',
      ]);

      Permission::create([
         'name'          => 'Ver detalle del área',
         'slug'          => 'area.edit',
         'description'   => 'Editar la información básica de la área',
      ]);

      Permission::create([
         'name'          => 'Creación de áreas',
         'slug'          => 'area.create',
         'description'   => 'Podría crear nuevas áreas en el sistema',
      ]);

      //Soportes
      Permission::create([
         'name'          => 'Navegar todas los soportes',
         'slug'          => 'soporte.index',
         'description'   => 'Lista y navega todos los soportes de cada usuario registrado en el sistema',
      ]);

      Permission::create([
         'name'          => 'Navegar Soportes',
         'slug'          => 'soportes',
         'description'   => 'Lista y navega todos los soportes de cada empresa registradas en el sistema',
      ]);

      Permission::create([
         'name'          => 'Actualizar los datos de un soporte',
         'slug'          => 'soporte.update',
         'description'   => 'Actualizar el soporte',
      ]);

      Permission::create([
         'name'          => 'Ver detalle del soporte',
         'slug'          => 'soporte.edit',
         'description'   => 'Editar la información básica del soporte',
      ]);

      Permission::create([
         'name'          => 'Creación de soportes',
         'slug'          => 'soporte.create',
         'description'   => 'Podría crear nuevos soportes en el sistema',
      ]);

      //Salarios
      Permission::create([
         'name'          => 'Navegar todas los salarios',
         'slug'          => 'salario.index',
         'description'   => 'Lista y navega todos los salarios de cada usuario registrado en el sistema',
      ]);

      Permission::create([
         'name'          => 'Generar y asignar un salario',
         'slug'          => 'salario.create',
         'description'   => 'Crear un salario',
      ]);

            Permission::create([
         'name'          => 'Eliminar un salario',
         'slug'          => 'salario.destroy',
         'description'   => 'Eliminar un salario',
      ]);

      // dotaciones
      Permission::create([
         'name'          => 'Programar entrega de dotaciones',
         'slug'          => 'programa.dotacion',
         'description'   => 'Programa la entrega de dotaciones en la organización',
      ]);

      Permission::create([
         'name'          => 'Editar enrega de dotaciones',
         'slug'          => 'edita.dotacion',
         'description'   => 'anexa personal, tallas, cantidades',
      ]);

      Permission::create([
         'name'          => 'Consulta entrega de dotaciones',
         'slug'          => 'consulta.dotacion',
         'description'   => 'Consulta el historial de entregas',
      ]);

      // vacaciones
      Permission::create([
         'name'          => 'Programar vacaciones al personal',
         'slug'          => 'programa.vacacion',
         'description'   => 'Programa la entrega de vacaciones en la organización',
      ]);

      Permission::create([
         'name'          => 'Editar entrega de vacaciones',
         'slug'          => 'edita.vacacion',
         'description'   => 'REgistra fechas de regreso, aplazamientos, etc',
      ]);

      Permission::create([
         'name'          => 'Consulta Vacaciones',
         'slug'          => 'consulta.vacacion',
         'description'   => 'Consulta el historial de vacaciones del personal',
      ]);


      // Incapacidades
      Permission::create([
         'name'          => 'Genera y edita incapacidades',
         'slug'          => 'edita.incapacidad',
         'description'   => 'REgistra fechas de regreso, pagos, etc',
      ]);

      Permission::create([
         'name'          => 'Consulta incapacidades',
         'slug'          => 'consulta.incapacidad',
         'description'   => 'Consulta el historial de incapacidades del personal',
      ]);

      // correspondencia
      Permission::create([
         'name'          => 'Navegar todas las solicitudes de correspondencia de la empresa',
         'slug'          => 'corres.index',
         'description'   => 'Lista y navega todas las solicitudes de correspondencia de cada empresa',
      ]);

      Permission::create([
         'name'          => 'Ver detalle de solicitud de correspondencia',
         'slug'          => 'corres.show',
         'description'   => 'Ve en detalle cada solicitud del sistema',
      ]);

      Permission::create([
         'name'          => 'Edición de solicitud diferente a remitente',
         'slug'          => 'corres.edit',
         'description'   => 'Podría editar cualquier dato de una solicitud generada en la empresa respectiva',
      ]);

      Permission::create([
         'name'          => 'Genera Guías',
         'slug'          => 'generaguias',
         'description'   => 'Puede generar las guias dentro del sistema',
      ]);

      Permission::create([
         'name'          => 'Configuracion Correspondencia',
         'slug'          => 'configcorres',
         'description'   => 'Puede configurar todo el módulo de correspondencia de la empresa',
      ]);

      Permission::create([
         'name'          => 'Configuracion General de Correspondencia',
         'slug'          => 'configcorresuper',
         'description'   => 'Puede configurar todo el módulo de correspondencia de todas las empresas',
      ]);

      Permission::create([
         'name'          => 'Auditoria de Correspondencia',
         'slug'          => 'auditorcorres',
         'description'   => 'Puede ver todos los indicadores del área',
      ]);

      // Facturación
      Permission::create([
         'name'          => 'Administrador de Facturación',
         'slug'          => 'adminfac',
         'description'   => 'Controla todo el modulo de facturación',
      ]);

      Permission::create([
         'name'          => 'Coordinador de facturación',
         'slug'          => 'coorfac',
         'description'   => 'Puede facturar, consultar facturas y ver listas de precios',
      ]);

      Permission::create([
         'name'          => 'Coordinador de Cartera',
         'slug'          => 'coorcar',
         'description'   => 'Puede consultar facturas y registrar pagos de las mismas',
      ]);

      Permission::create([
         'name'          => 'Auditor facturación',
         'slug'          => 'audifac',
         'description'   => 'Puede ver todas las facturas y listas de precios',
      ]);

      Permission::create([
         'name'          => 'Acceso Cliente',
         'slug'          => 'cliefac',
         'description'   => 'Verifica las facturas propias de cada cliente, solicita la facturación de servicios',
      ]);

      // Diligencias
      Permission::create([
         'name'          => 'Listar diligencias',
         'slug'          => 'diligencia.list',
         'description'   => 'Muestra todas las diligencias en el sistema',
      ]);

      Permission::create([
         'name'          => 'Crear diligencias',
         'slug'          => 'diligencia.create',
         'description'   => 'Crea diligencias en el sistema',
      ]);
      Permission::create([
         'name'          => 'Editar diligencias',
         'slug'          => 'diligencia.edit',
         'description'   => 'Edita diligencias en el sistema',
      ]);
      Permission::create([
         'name'          => 'Elimina diligencias',
         'slug'          => 'diligencia.delete',
         'description'   => 'Elimina diligencias en el sistema',
      ]);
      Permission::create([
         'name'          => 'gestionar diligencias',
         'slug'          => 'diligencia.gest',
         'description'   => 'Gestion de las diligencias en el sistema',
      ]);
      Permission::create([
         'name'          => 'Mensajero diligencias',
         'slug'          => 'diligencia.mensajero',
         'description'   => 'Modulo de mensajero para diligencias',
      ]);

      // humana
      Permission::create([
         'name'          => 'Super Usuario Humana',
         'slug'          => 'superhumana',
         'description'   => 'Acceso a todos los parámetros de control del modulo',
      ]);

      Permission::create([
         'name'          => 'Administrador Humana',
         'slug'          => 'adminhumana',
         'description'   => 'Administra la mayor parte del modulo',
      ]);

      Permission::create([
         'name'          => 'Operador Humana',
         'slug'          => 'opehumana',
         'description'   => 'Administra la mayor parte del modulo',
      ]);

   }
}
