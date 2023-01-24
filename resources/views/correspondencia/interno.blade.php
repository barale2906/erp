<!-- Modal -->
<div class="modal fade" id="interno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Envío Interno</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div id="internoform">
                  <form class="form-inline" v-on:submit.prevent="crearenvioi" method="POST"  >
                     @csrf
                           <div class="modal-body">

                              <input type="hidden" v-model="solicitai" name="solicitai" id="solicitai">
                              <input type="hidden" v-model="namei" name="namei" id="namei">
                              <input type="hidden" v-model="empresai" name="empresai" id="empresai">
                              <input type="hidden" v-model="sucursali" name="sucursali" id="sucursali">
                              <input type="hidden" v-model="nombresucursali" name="nombresucursali" id="nombresucursali">
                              <input type="hidden" v-model="areai" name="areai" id="areai">
                              <input type="hidden" v-model="nombreareai" name="nombreareai" id="nombreareai">

                              <input type="hidden" v-model="destinatarioi" name="destinatarioi" id="destinatarioi">
                              <input type="hidden" v-model="nombredestinatarioi" name="nombredestinatarioi" id="nombredestinatarioi">
                              <input type="hidden" v-model="sedei" name="sedei" id="sedei">
                              <input type="hidden" v-model="nombresedei" name="nombresedei" id="nombresedei">
                              <input type="hidden" v-model="ubicacioni" name="ubicacioni" id="ubicacioni">
                              <input type="hidden" v-model="nombreubicacioni" name="nombreubicacioni" id="nombreubicacioni">
                              <input type="hidden" v-model="horarioi" name="horarioi" id="horarioi">

                              <div class="input-group mb-2 mr-sm-2">
                                 <div class="input-group-prepend">
                                       <div class="input-group-text">Descripción</div>
                                 </div>
                                 <textarea class="form-control" v-model="descripcioni" @blur="cargarclasei"  name="descripcioni" id="descripcioni" cols="30" rows="1"
                                       required placeholder="Un sobre, una caja, un bulto..."></textarea>
                              </div>
                              <div class="input-group mb-2 mr-sm-2">
                                 <div class="input-group-prepend">
                                       <div class="input-group-text">Detalle</div>
                                 </div>
                                 <textarea class="form-control" v-model="detallei" name="detallei" id="detallei" cols="30" rows="1"
                                       required placeholder="El sobre contiene..."></textarea>
                              </div>
                              <div class="input-group mb-2 mr-sm-2">
                                 <div class="input-group-prepend">
                                       <div class="input-group-text">Clase de Entrega</div>
                                 </div>

                                 <select v-model="clasei" name="clasei" id="clasei" @change="destinatario" class="form-control" required>
                                          <option value="">Seleccione clase de entrega...</option>
                                          <option v-for="clase in clasesi" v-bind:value="clase.id">
                                             @{{ clase.nombre }}
                                          </option>
                                 </select>
                              </div>

                              @can('haveaccess','misdatos')
                                 <button type="submit" class="btn btn-info mb-2"><i class="far fa-plus-square"></i></button>
                              @endcan



                           </div>
                           <div class="modal-footer">

                           </div>
                     </form>
               </div>

      </div>
   </div>
</div>

