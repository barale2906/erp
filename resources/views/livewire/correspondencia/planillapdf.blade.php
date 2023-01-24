<div>
   @if ($idplanilla>0)
   <div class="col-12">
      <div class="info-box">
         <span class="info-box-icon bg-danger elevation-1"><i class="far fa-file-pdf"></i></span>
         <div class="info-box-content">
               <span class="info-box-text text-capitalize">GENERAR PDF</span>
                  <span class="info-box-number">
                     <a href="{{route('planillapdf', $idplanilla)}}">{{$idplanilla}}</a>
                  </span>
         </div>
         <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
   </div>
   @endif
</div>
