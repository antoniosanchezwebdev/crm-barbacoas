<div class="container mx-auto">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .btn-form:hover {
            background-color: #d70613 !important;
        }
    </style>
    <form wire:submit.prevent="submit">
        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
        <div class="card">
            <h5 class="card-header">Datos básicos</h5>
            <div class="card-body">
                <div class="mb-3 row d-flex align-items-center">
                    <label for="titulo" class="col-sm-2 col-form-label">Descripción corta de los trabajos
                        solicitados</label>
                    <div class="col-sm-10">
                        <input type="text" wire:model="titulo" class="form-control" name="titulo" id="titulo">
                        @error('titulo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row d-flex align-items-center">
                    <label for="descripcion" class="col-sm-2 col-form-label">Descripción larga de los trabajos
                        solicitados</label>
                    <div class="col-sm-10">
                        <textarea wire:model="descripcion" class="form-control" name="descripcion" id="descripcion"></textarea>
                        @error('descripcion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row d-flex align-items-center">
                    <label for="fecha" class="col-sm-2 col-form-label">Fecha de emisión</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" wire:model="fecha" class="form-control" name="fecha"
                            id="fecha">
                        @error('fecha')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row d-flex align-items-center" x-data="" x-init="$('#select2-cliente').select2();
                $('#select2-cliente').on('change', function(e) {
                    var data = $('#select2-cliente').select2('val');
                    @this.set('id_cliente', data);
                });
                livewire.on('refreshTomSelect', () => {
                    $('#select2-cliente').select2();
                    $('#select2-cliente').on('change', function(e) {
                        var data = $('#select2-cliente').select2('val');
                        @this.set('id_cliente', data);
                    });
                });">
                    <label for="select2-cliente" class="col-sm-2 col-form-label">Cliente</label>
                    <div class="col-sm-10" wire:ignore>
                        <select name="select2-cliente" id="select2-cliente" class="w-100">
                            @if (!empty($clientes))
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('numero_presupuesto')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row d-flex align-items-center">
                    <label for="fecha" class="col-sm-2 col-form-label">Observaciones</label>
                    <div class="col-sm-10">
                        <textarea wire:model="observaciones" class="form-control" name="observaciones" id="observaciones"></textarea>
                        @error('descripcion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


            </div>
        </div>
        <br>
        <div class="card">
            <h5 class="card-header">Operarios</h5>
            <div class="card-body">
                <h4>Operarios asignados </h4>
                <hr />
                <ul>
                    @foreach ($operarios as $operario)
                        <li>{{ $trabajadores->where('id', $operario)->first()->name }}</li>
                    @endforeach
                </ul>
                <hr />
                <h4>Operarios disponibles</h4>
                <div wire:key='hola' class="mb-3 row d-flex align-items-center" x-data=""
                    x-init="$('#select2-trabajador').select2();
                    $('#select2-trabajador').on('change', function(e) {
                        var data = $('#select2-trabajador').select2('val');
                        @this.set('trabajador_id', data);
                    });
                    livewire.on('refreshTomSelect', () => {
                        setTimeout(function() {
                            console.log('si');
                            $('#select2-trabajador').select2('destroy');
                            $('#select2-trabajador').select2();
                            $('#select2-trabajador').on('change', function(e) {
                                var data = $(this).val();
                                @this.set('trabajador_id', data);
                            });
                        }, 500);
                    });">
                    <label for="select2-trabajador" class="col-sm-2 col-form-label">Trabajador asignado</label>
                    <div class="col-sm-10" wire:ignore>
                        <select name="select2-cliente" id="select2-trabajador" class="w-100">
                            @if (!empty($trabajadores))
                                @foreach ($trabajadores as $trabajadorSel)
                                    <option value="{{ $trabajadorSel->id }}">{{ $trabajadorSel->id }} -
                                        {{ $trabajadorSel->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('denominacion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-form" style="background-color: #b10510; color: white;"
                            wire:click="addTrabajador">Añadir operario</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <h5 class="card-header">Trabajos a realizar</h5>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th><label for="titulo" class="col-form-label">Título</label>
                        </th>

                        <th><label for="descripcion" class="col-form-label">Descripción</label>
                        </th>

                        <th><label for="horas_estimadas" class="col-form-label"
                                style="margin-right: -75px !important;">Horas
                                estimadas</label>
                        </th>
                        <th><label for="precio" class="col-form-label">Precio</label></th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($this->trabajos_realizar); $i++)
                            <tr>
                                <td>
                                    <input type="text" wire:model="trabajos_realizar.{{ $i }}.titulo"
                                        class="form-control" name="titulo_{{ $i }}"
                                        id="titulo_{{ $i }}">
                                </td>

                                <td>
                                    <input type="text"
                                        wire:model="trabajos_realizar.{{ $i }}.descripcion"
                                        class="form-control" name="descripcion_{{ $i }}"
                                        id="descripcion_{{ $i }}">
                                </td>

                                <td>
                                    <input type="number"
                                        wire:model="trabajos_realizar.{{ $i }}.horas_estimadas"
                                        class="form-control" name="horas_estimadas_{{ $i }}"
                                        id="horas_estimadas_{{ $i }}">
                                </td>
                                <td>
                                    <input type="number" wire:model="trabajos_realizar.{{ $i }}.precio"
                                        class="form-control" name="precio_{{ $i }}"
                                        id="precio_{{ $i }}" wire:change='generarSubtotal'>
                                </td>
                                <td> <button type="button" class="btn"
                                        style="background-color: #b10510; color: white;"
                                        wire:click.prevent="deleteTrabajo({$i})">X</button></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                <button class="btn btn-form" style="background-color: #b10510; color: white;"
                    wire:click.prevent="addTrabajo">Añadir
                    trabajo</button>
                <hr />
                <label for="subtotal" class="col-form-label">Subtotal:</label>
                <input type="text" wire:model="subtotal" class="form-control" name="subtotal" id="subtotal"
                    disabled>
                <label for="iva" class="col-form-label">IVA:</label><br>
                <select name="iva" class="w-100 form-control" id="iva" wire:model="iva"
                    wire:change='generarSubtotal'>
                    <option value="0">Sin IVA (0%)</option>
                    <option value="4">IVA superreducido (4%)</option>
                    <option value="10">IVA reducido (10%)</option>
                    <option value="21">IVA general (21%)</option>
                </select>
                <label for="precio" class="col-form-label">Total:</label>
                <input type="text" wire:model="precio" class="form-control" name="precio" id="precio"
                    disabled>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-form w-100" style="background-color: #b10510; color: white;">Crear
            parte de
            trabajo</button>

    </form>
</div>
