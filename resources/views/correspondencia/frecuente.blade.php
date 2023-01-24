<!-- Modal -->
<div class="modal fade" id="frecuente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Destinatario Frecuente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="frecuenteform">
                    <form class="form-inline" v-on:submit.prevent="creardestinatario" method="POST" >
                        @csrf
                            <div class="modal-body">

                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Destinatario</div>
                                    </div>
                                    <input type="text" v-model="destinatario" class="form-control" name="destinatario" id="destinatario" required autofocus>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">Dirección</div>
                                    </div>
                                    <textarea class="form-control" v-model="direccion" name="direccion" id="direccion" cols="30" rows="1" required></textarea>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Ciudad</div>
                                    </div>

                                    <select v-model="ciudadf" @change="cargarbasicosf" name="ciudadf" id="ciudadf" class="form-control" required>
                                            <option value="">Seleccione Ciudad de destino...</option>
                                            <option v-for="ciudad in ciudades" v-bind:value="ciudad.ciudad">
                                                @{{ ciudad.ciudad }}
                                            </option>
                                    </select>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Horario</div>
                                    </div>
                                    <textarea class="form-control" v-model="horariof" name="horariof" id="horariof" cols="30" rows="1"
                                        required placeholder="Días y horarios de entrega"></textarea>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">Observaciones</div>
                                    </div>
                                    <textarea class="form-control" v-model="observaciones"
                                        name="observaciones" id="observaciones" cols="30" rows="1" required></textarea>
                                </div>



                                <input type="hidden" v-model="sucursalf" name="sucursalf" id="sucursalf">
                                <input type="hidden" v-model="areaf" name="areaf" id="areaf">

                                @can('haveaccess','misdatos')
                                    <button type="submit" class="btn btn-success mb-2"><i class="far fa-plus-square"></i></button>
                                @endcan


                            </div>
                            <div class="modal-footer">

                            </div>
                        </form>
                </div>

        </div>
    </div>
</div>

