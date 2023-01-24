<!DOCTYPE html>
   <html lang="es">
   <head>
      <title>Planilla N° {{$planilla->id}}</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <meta name="title" content="Planilla N° {{$planilla->id}}">
      <meta name="description" content="planilla de entrega">

      <style>
      @page {
         margin: 0cm 0cm;
         font-family: Arial;
      }

      body {
         margin: 3cm 1cm 1cm;
      }

      header {
         position: fixed;
         top: 0.5cm;
         left: 0cm;
         right: 0cm;
         height: 2cm;
         text-align: center;
         line-height: 30px;
      }

      footer {
         position: fixed;
         bottom: 0cm;
         left: 0cm;
         right: 0cm;
         height: 2cm;
         text-align: center;
         line-height: 35px;
      }

			table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
         padding: 2px;
			}

			td{
			border: 1px solid #dddddd;
			text-align: left;
			font-size: 11px;
			padding: 8px;
			}

			th {
			border: 1px solid #dddddd;
			text-align: left;
			font-size: 11px;
			padding: 8px;
			}

			thead{
				border: 2px solid #dddddd;
				background:#E5E7E9;

			}
			</style>

   </head>
<body>
   <header>
      <table>
         <thead>
            <tr>
               <th><img src="{{$planilla->logo}}" alt="logo"></th>
               <th>Planilla N°: {{$planilla->id}}</th>
               <th>Fecha: {{$planilla->fecha}}</th>
               <th>Ruta: {{$planilla->ruta}}</th>
               <th>Operador: {{$planilla->name}}</th>
            </tr>
         </thead>
      </table>
   </header>
   <table class="table table-bordered table">
      <thead>
         <tr>
            <th>Orden</th>
            <th>ID / Dirección</th>
            <th>Horario / Teléfono</th>
            <th>Ciudad</th>
            <th>°C - Factura</th>
            <th>Destinatario</th>
            <th>Cobro Cliente</th>
            <th>Cobro Transporte</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($correspondencias as $correspondencia)
            <tr>
               <td>{{$correspondencia->orden}}</td>
               <td>{{$correspondencia->id}} - {{$correspondencia->nombresede}}</td>
               <td>{{$correspondencia->horario}}</td>
               <td>{{$correspondencia->nombreubicacion}}</td>
               <td>{{$correspondencia->descripcion}}</td>
               <td>{{$correspondencia->nombredestinatario}}</td>
               <td>
                  @if ($correspondencia->cobrocliente>0)
                     {{$correspondencia->cobrocliente}}
                  @endif
               </td>
               <td>
                  @if ($correspondencia->cobro>0)
                     {{$correspondencia->cobro}}
                  @endif
               </td>

            </tr>
         @endforeach
      </tbody>
   </table>

   <footer>
      <h5>www.somosenviosydiligencias.com - Teléfono: 290 6773 - 310 477 1708 - Email: somos.enviosydiligencias@gmail.com</h5>
   </footer>

</body>
</html>
