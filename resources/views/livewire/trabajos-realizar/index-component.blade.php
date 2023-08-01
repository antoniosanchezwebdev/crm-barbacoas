<div class="container mx-auto">
    <div class="card" wire:ignore>
        <h5 class="card-header">Resultados</h5>
        <div class="card-body" x-data="{}" x-init="$nextTick(() => {
            $('#tableSinAsignar').DataTable({
                responsive: true,
                fixedHeader: true,
                searching: false,
                paging: false,
            });
        })">
            @if ($tareas->count() > 0)
                <table class="table responsive" id="tableSinAsignar">
                    <thead>
                        <tr>
                            <th scope="col">Descripción corta</th>
                            <th scope="col">Descripción larga</th>
                            <th scope="col">Horas estimadas</th>
                            <th scope="col">Horas trabajadas</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Ver/Editar</th>
                            @if ($tareas->where('estado', 'Revisión')->count() > 0)
                                <th scope="col"> Revisar </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Recorre los presupuestos --}}
                        @foreach ($tareas as $tarea)
                            <tr>
                                <td>{{ $tarea->titulo }}</th>

                                <td>{{ $tarea->descripcion }} </td>

                                <td>{{ $tarea->tiempo_estimado }}</th>

                                <td>{{ $tarea->tiempo_real }} </td>

                                <td>{{ $tarea->estado }} </td>

                                @if ($tarea->trabajador_id != 0)
                                    <td> <button type="button" class="btn btn-tab boton-producto"
                                            onclick="Livewire.emit('seleccionarProducto', {{ $tarea->id }});">Ver/Editar</button>
                                    </td>
                                @else
                                    <td> <button type="button" class="btn btn-tab boton-producto"
                                            onclick="Livewire.emit('seleccionarProducto', {{ $tarea->id }});">Asignar
                                            tarea</button>
                                    </td>
                                @endif
                                @if ($tareas->where('estado', 'Revisión')->count() > 0)
                                    @if ($tarea->estado == 'Revisión')
                                        <td> <button type="button" class="btn btn-tab boton-producto" id="complete-button-{{$tarea->id}}">Marcar
                                                como completada</button>
                                                <script>
                                                    document.getElementById('complete-button-{{ $tarea->id }}').addEventListener('click', function(event) {
                                                        event.preventDefault();

                                                        Swal.fire({
                                                            title: '¿Estás seguro?',
                                                            text: "Asegúrate de que todo en la tarea está listo.",
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Completar tarea'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // Esto llamará al método confirmDelete de Livewire y pasará el ID del item
                                                                @this.call('completarTarea', {{ $tarea->id }})
                                                            }
                                                        })
                                                    });
                                                </script>
                                            <button type="button" class="btn btn-tab boton-producto"
                                                wire:click.prevent="devolverTarea('{{ $tarea->id }}')">Devolver
                                                tarea</button>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3>¡No hay tareas sin asignar!</h3>
            @endif
            </tbody>
            </table>
        </div>
    </div>
</div>
