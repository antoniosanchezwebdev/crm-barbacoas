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
                            <th scope="col">Nombre de cliente</th>
                            <th scope="col">Fecha emisión</th>
                            <th scope="col">PVP</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Ver/Editar</th>
                            @if ($tareas->where('estado', 'Completada')->count() > 0)
                                <th scope="col"> Firmar </th>
                            @endif
                            @if ($tareas->where('estado', 'Firmada')->count() > 0)
                                <th scope="col"> Ver documento firmado </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Recorre los presupuestos --}}
                        @foreach ($tareas as $tarea)
                            <tr>
                                <td>{{ $tarea->titulo }}</td>

                                <td>{{ $tarea->descripcion }} </td>

                                <td>{{ $clientes->where('id', $tarea->id_cliente)->first()->nombre }} </td>

                                <td>{{ $tarea->fecha }}</td>

                                <td>{{ $tarea->precio }} €</td>

                                <td>{{ $tarea->estado }}</td>

                                <td>
                                    <button type="button" class="btn btn-tab boton-producto"
                                        onclick="Livewire.emit('seleccionarProducto', {{ $tarea->id }});">Ver/Editar</button>
                                </td>
                                @if ($tareas->where('estado', 'Completada')->count() > 0)
                                    <td> <button type="button" class="btn btn-tab boton-producto"
                                            data-bs-toggle="modal"
                                            data-bs-target="#signatureModal-{{ $tarea->id }}">Marcar
                                            como completada</button>
                                        <div class="modal fade" id="signatureModal-{{ $tarea->id }}" tabindex="-1"
                                            aria-labelledby="signatureModalLabel-{{ $tarea->id }}" aria-hidden="true">
                                            @livewire('partes-trabajo.firma-component', ['parte_id' => $tarea->id])
                                        </div>
                                    </td>
                                @endif
                                @if ($tareas->where('estado', 'Firmada')->count() > 0)
                                    <td> <ul> <li><a href="{{asset('storage/' . $tarea->documentos)}}" class="btn btn-tab">Ver documento</a></li>
                                     <li><button wire:click.prevent="enviarCorreo('{{$tarea->id}}')" class="btn btn-tab">Enviar documento al cliente</button></li></ul> </td>
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
