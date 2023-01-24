<div class="row justify-content-center">
   <table class="table table-bordered table-striped table-responsive">
      <thead>
         <tr>
            <th scope="col"></th>
            <th scope="col">Tipo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Número</th>
            <th scope="col">Estado</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($listado as $lista)
            <tr>
               <td></td>
               <td>{{$lista->tipo}}</td>
               <td>{{$lista->nombre}}</td>
               <td>{{$lista->numero}}</td>
               <td>{{$lista->estado}}</td>
            </tr>
         @endforeach
      </tbody>
   </table>
</div>
