<!-- Modal -->
<div class="modal fade" id="externo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Envío Externo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="externoform">

                    <form class="form-inline" v-on:submit.prevent="crearenvio" method="POST" >
                        @csrf
                            <div class="modal-body">

                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Destinatario</div>
                                    </div>
                                    <input type="text" v-model="nombredestinatario" class="form-control" name="nombredestinatario" id="nombredestinatario" required autofocus>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">Dirección</div>
                                    </div>
                                    <textarea class="form-control" v-model="nombresede" name="nombresede" id="nombresede" cols="30" rows="1" required></textarea>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Ciudad</div>
                                    </div>

                                    <select v-model="nombreubicacion" @change="cargarclase" name="nombreubicacion" id="nombreubicacion" class="form-control" required>
                                            <option value="">Seleccione Ciudad de destino...</option>
                                            <option v-for="ciudad in ciudads" v-bind:value="ciudad.ciudad">
                                                @{{ ciudad.ciudad }}
                                            </option>
                                    </select>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Horario</div>
                                    </div>
                                    <textarea class="form-control" v-model="horario" name="horario" id="horario" cols="30" rows="1"
                                        required placeholder="Días y horarios de entrega"></textarea>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Descripción</div>
                                    </div>
                                    <textarea class="form-control" v-model="descripcion" name="descripcion" id="descripcion" cols="30" rows="1"
                                        required placeholder="Un sobre, una caja, un bulto..."></textarea>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Detalle</div>
                                    </div>
                                    <textarea class="form-control" v-model="detalle" name="detalle" id="detalle" cols="30" rows="1"
                                        required placeholder="El sobre contiene..."></textarea>
                                </div>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Clase de Entrega</div>
                                    </div>

                                    <select v-model="clase" @change="cargarbasicos" name="clase" id="clase" class="form-control" required>
                                            <option value="">Seleccione clase de entrega...</option>
                                            <option v-for="clase in clases" v-bind:value="clase.id">
                                                @{{ clase.nombre }}
                                            </option>
                                    </select>
                                </div>

                                <input type="hidden" v-model="solicita" name="solicita" id="solicita">
                                <input type="hidden" v-model="name" name="name" id="name">
                                <input type="hidden" v-model="empresa_id" name="empresa_id" id="empresa_id">
                                <input type="hidden" v-model="sucursal" name="sucursal" id="sucursal">
                                <input type="hidden" v-model="nombresucursal" name="nombresucursal" id="nombresucursal">
                                <input type="hidden" v-model="area" name="area" id="area">
                                <input type="hidden" v-model="nombrearea" name="nombrearea" id="nombrearea">
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

