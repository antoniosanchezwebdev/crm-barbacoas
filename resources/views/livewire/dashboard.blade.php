<div class="row justify-content-center mt-2" style="width: 95% !important; margin: auto;">
    <style>
        .nav-link {
            color: #b10510 !important;
        }

        .nav-link:disabled {
            color: #000 !important;
        }

        .nav-link.active {
            color: #fd0716 !important;
        }

        .btn-tab {
            background-color: #b10510;
            color: #fff;
        }

        .btn-tab:hover {
            background-color: #b10510;
            color: #fff;
        }

        .btn-outline-tab {
            background-color: #fff;
            border: 1px solid #b10510;
            color: #b10510;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
            background-color: #fd0716 !important;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td.dtr-control:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr.parent>th.dtr-control:before {
            background-color: #b10510 !important;
        }
    </style>
    <div class="row justify-content-center mt-2">
        <div class="col">
            <div class="card">
                <div class="card-header">Horas trabajadas hoy</div>
                <div class="card-body">
                    <b> {{ $this->horasTrabajadasTotales('hoy') }} </b>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">Horas trabajadas ayer</div>
                <div class="card-body">
                    <b> {{ $this->horasTrabajadasTotales('ayer') }} </b>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">Horas trabajadas esta semana</div>
                <div class="card-body">
                    <b> {{ $this->horasTrabajadasTotales('semana') }} </b>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">Horas trabajadas este mes</div>
                <div class="card-body">
                    <b> {{ $this->horasTrabajadasTotales('mes') }} </b>
                </div>
            </div>
        </div>

    </div>
    <div class="row justify-content-center mt-5">
        @if (count($tareas) > 0)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h1> Tareas asignadas </h1>
                    </div>
                    <div class="card-body">
                        <div class="accordion border-tab" id="accordionExample2">
                            @foreach ($tareas as $tareaIndex => $tarea)
                                @if ($tarea->estado == 'Asignada')
                                    <div class="card accordion-item">
                                        <button class="card-header accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $tareaIndex }}"
                                            aria-expanded="false" aria-controls="collapse{{ $tareaIndex }}">
                                            <h5 class="accordion-header" id="heading{{ $tareaIndex }}">
                                                {{ $tarea->titulo }}
                                            </h5>
                                        </button>
                                        <div id="collapse{{ $tareaIndex }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $tareaIndex }}"
                                            data-bs-parent="#accordionExample2">
                                            <div class="card-body accordion-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-sm-3">
                                                        <h5>ESTADO:</h5>
                                                        {{ $tarea->estado }}
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <h5>TIEMPO ESTIMADO: </h5>
                                                        {{ $tarea->tiempo_estimado }}
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <h5>TIEMPO REAL: </h5>
                                                        <p>{{ $this->tiempoTotalTrabajado($tarea->id, Auth::id()) }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="accordion border-tab"
                                                    id="accordionExample1{{ $tareaIndex }}">
                                                    <div class="card accordion-item">
                                                        <button class="card-header accordion-button collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse1{{ $tareaIndex }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapse1{{ $tareaIndex }}">
                                                            <h5 class="accordion-header"
                                                                id="heading1{{ $tareaIndex }}">
                                                                Datos
                                                            </h5>
                                                        </button>
                                                        <div id="collapse1{{ $tareaIndex }}"
                                                            class="accordion-collapse collapse"
                                                            aria-labelledby="heading1{{ $tareaIndex }}"
                                                            data-bs-parent="#accordionExample1{{ $tareaIndex }}">
                                                            <div class="card-body accordion-body">
                                                                <h5 class="card-title">Descripción del trabajo:
                                                                </h5>
                                                                <p class="card-text">{{ $tarea->descripcion }}</p>

                                                                <h5 class="card-title">Precio (IVA incluido):</h5>
                                                                <p class="card-text">
                                                                    {{ $tarea->precio }}
                                                                </p>

                                                                <h5 class="card-title">Comentarios:</h5>
                                                                <p class="card-text" id="comentarios">
                                                                    {{ $tarea->observaciones }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row justify-center mb-3">
                                                    @if ($tarea->logs()->count() > 0)
                                                        <div class="col"> <button type="button"
                                                                class="btn btn-tab w-100"
                                                                wire:click="iniciarTarea('{{ $tarea->id }}', '{{ Auth::id() }}')">Reanudar
                                                                tarea</button></div>
                                                    @else
                                                        <div class="col"> <button type="button"
                                                                class="btn btn-tab w-100"
                                                                wire:click="iniciarTarea('{{ $tarea->id }}', '{{ Auth::id() }}')">Iniciar
                                                                tarea</button></div>
                                                    @endif
                                                    <div class="col"><button
                                                            wire:click="completarTarea({{ $tarea->id }})"
                                                            id="delete-button-{{ $tarea->id }}" type="button"
                                                            class="btn btn-secondary w-100">Mandar a revisión</button>

                                                        <script>
                                                            document.getElementById('delete-button-{{ $tarea->id }}').addEventListener('click', function(event) {
                                                                event.preventDefault();

                                                                Swal.fire({
                                                                    title: '¿Estás seguro?',
                                                                    text: "Asegúrate de que todo en la tarea está listo.",
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#3085d6',
                                                                    cancelButtonColor: '#d33',
                                                                    confirmButtonText: 'Enviar a revisión'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        // Esto llamará al método confirmDelete de Livewire y pasará el ID del item
                                                                        @this.call('completarTarea', {{ $tarea->id }})
                                                                    }
                                                                })
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1> Tarea activa </h1>
                    </div>
                    <div class="card-body">
                        <div class="accordion border-tab" id="accordionExample1">
                            @foreach ($tareas as $tareaIndex => $tarea)
                                @if ($tarea->estado == 'En curso')
                                    <div class="card accordion-item">
                                        <button class="card-header accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseEC{{ $tareaIndex }}"
                                            aria-expanded="false" aria-controls="collapseEC{{ $tareaIndex }}">
                                            <h5 class="accordion-header" id="headingEC{{ $tareaIndex }}">
                                                {{ $tarea->titulo }}
                                            </h5>
                                        </button>

                                        <div id="collapseEC{{ $tareaIndex }}" class="accordion-collapse collapse"
                                            aria-labelledby="headingEC{{ $tareaIndex }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="card-body accordion-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-sm-4">
                                                        <h5>ESTADO:</h5>
                                                        {{ $tarea->estado }}
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <h5>TIEMPO ESTIMADO: </h5>
                                                        {{ $tarea->tiempo_estimado }}
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <h5>TIEMPO REAL: </h5>
                                                        <p>{{ $this->tiempoTotalTrabajado($tarea->id, Auth::id()) }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="accordion border-tab"
                                                    id="accordionExample1EC{{ $tareaIndex }}">
                                                    <div class="card accordion-item">
                                                        <button class="card-header accordion-button collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse1EC{{ $tareaIndex }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapse1EC{{ $tareaIndex }}">
                                                            <h5 class="accordion-header"
                                                                id="heading1EC{{ $tareaIndex }}">
                                                                Datos
                                                            </h5>
                                                        </button>
                                                        <div id="collapse1EC{{ $tareaIndex }}"
                                                            class="accordion-collapse collapse"
                                                            aria-labelledby="heading1EC{{ $tareaIndex }}"
                                                            data-bs-parent="#accordionExample1EC{{ $tareaIndex }}">
                                                            <div class="card-body accordion-body mb-3">
                                                                <h5 class="card-title">Descripción del trabajo:</h5>
                                                                <p class="card-text">{{ $tarea->descripcion }}</p>

                                                                <h5 class="card-title">Precio (IVA incluido):</h5>
                                                                <p class="card-text">
                                                                    {{ $tarea->precio }}
                                                                </p>

                                                                <h5 class="card-title">Comentarios:</h5>
                                                                <p class="card-text" id="comentarios">
                                                                    {{ $tarea->observaciones }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row justify-center mb-3">
                                                    <div class="col"> <button type="button"
                                                            class="btn btn-danger w-100"
                                                            wire:click="pausarTarea('{{ $tarea->id }}', '{{ Auth::id() }}')">Pausar
                                                            tarea</button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @if ($tareas->where('estado', 'En curso')->count() < 1)
                                <h3> Ahora mismo no hay tareas activas. </h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <h3 class="mt-3 text-center"> <b> No hay tareas activas. </b> </h3>
        @endif
    </div>
</div>
