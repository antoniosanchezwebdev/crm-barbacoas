<div class="container mx-auto">

    <script></script>
    @php
        use Carbon\CarbonInterval;
    @endphp
    <form wire:submit.prevent="update">
        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
        <div class="card">
            <h5 class="card-header">Datos básicos</h5>
            <div class="card-body">
                <div class="mb-3 row d-flex align-items-center">
                    <label for="titulo" class="col-sm-2 col-form-label">Nombre de la tarea</label>
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
                    <label for="tiempo_estimado" class="col-sm-2 col-form-label">Tiempo estimado</label>
                    <div class="col-sm-10">
                        <input type="time" wire:model="tiempo_estimado" class="form-control" name="tiempo_estimado"
                            id="tiempo_estimado">
                        @error('tiempo_estimado')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row d-flex align-items-center">
                    <label for="tiempo_real" class="col-sm-2 col-form-label">Tiempo real</label>
                    <div class="col-sm-10">
                        <input type="time" wire:model="tiempo_real" class="form-control" name="tiempo_real"
                            id="tiempo_real" disabled>
                        @error('tiempo_real')
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
                <h4>Seleccionar operario</h4>
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
                </div>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Materiales</h5>
            <div class="card-body">
                <table class="table responsive">
                    <thead>
                        <th><label for="titulo" class="col-form-label">Título</label>
                        </th>

                        <th><label for="descripcion" class="col-form-label">Cantidad</label>
                        </th>
                        <th><label for="precio" class="col-form-label">Precio</label></th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($this->materialesAux); $i++)
                            <tr>
                                <td>
                                    <input type="text" wire:model="materialesAux.{{ $i }}.titulo"
                                        class="form-control" name="tituloAux_{{ $i }}"
                                        id="tituloAux_{{ $i }}" disabled>
                                </td>

                                <td>
                                    <input type="number"
                                        wire:model="materialesAux.{{ $i }}.cantidad"
                                        class="form-control" name="cantidadAux_{{ $i }}"
                                        id="cantidadAux_{{ $i }}" wire:change='generarSubtotal'>
                                </td>
                                <td>
                                    <input type="number"
                                        wire:model="materialesAux.{{ $i }}.precio"
                                        class="form-control" name="precioAux_{{ $i }}"
                                        id="precioAux_{{ $i }}" wire:change='generarSubtotal' disabled>
                                </td>
                                <td> <button type="button" class="btn"
                                    style="background-color: #b10510; color: white;"
                                    wire:click.prevent="alertaTrabajo('{{ $i }}')">X</button></td>
                            </tr>
                        @endfor
                        @for ($i = 0; $i < count($this->materiales); $i++)
                            <tr>
                                <td>
                                    <input type="text" wire:model="materiales.{{ $i }}.titulo"
                                        class="form-control" name="titulo_{{ $i }}"
                                        id="titulo_{{ $i }}">
                                </td>

                                <td>
                                    <input type="number"
                                        wire:model="materiales.{{ $i }}.cantidad"
                                        class="form-control" name="cantidad_{{ $i }}"
                                        id="cantidad_{{ $i }}" wire:change='generarSubtotal' min="1">
                                </td>
                                <td>
                                    <input type="number" wire:model="materiales.{{ $i }}.precio"
                                        class="form-control" name="precio_{{ $i }}"
                                        id="precio_{{ $i }}" wire:change='generarSubtotal' min="0.01" step="0.01">
                                </td>
                                <td> <button type="button" class="btn"
                                        style="background-color: #b10510; color: white;"
                                        wire:click.prevent="deleteTrabajo('{{ $i }}')">X</button></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                <button class="btn btn-tab" wire:click.prevent="addTrabajo">Añadir
                    trabajo</button>
                <hr />
                <label for="subtotal" class="col-form-label">Subtotal:</label>
                <input type="text" wire:model="subtotal" class="form-control" name="subtotal" id="subtotal" step="0.01"
                    disabled>
                <label for="iva" class="col-form-label">IVA:</label><br>
                <select name="iva" class="w-100 form-control" id="iva" wire:model="iva"
                    wire:change='generarSubtotal'>
                    <option value="0">Sin IVA (0%)</option>
                    <option value="4">IVA superreducido (4%)
                    </option>
                    <option value="10">IVA reducido (10%)
                    </option>
                    <option value="21">IVA general (21%)</option>
                </select>
                <script>
                    console.log({{ $iva }});
                </script>
                <label for="precio" class="col-form-label">Total:</label>
                <input type="text" wire:model="precio" class="form-control" name="precio" id="precio" step="0.01"
                    disabled>
            </div>
        </div>
        <br>
        <div class="mb-3 row d-flex align-items-center">
            <button type="submit" class="btn btn-outline-info">Guardar</button>
        </div>
    </form>

</div>

</div>


@section('scripts')
    <script>
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'
            ],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        document.addEventListener('livewire:load', function() {


        })
        $(document).ready(function() {
            console.log('select2')
            $("#datepicker").datepicker();

            $("#datepicker").on('change', function(e) {
                @this.set('fecha_inicio', $('#datepicker').val());
            });
            $("#datepicker2").datepicker();

            $("#datepicker2").on('change', function(e) {
                @this.set('fecha_fin', $('#datepicker2').val());
            });

        });
    </script>
@endsection
