<div>
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
    @mobile
        @if ($tarea != null)
            @if ($tab == 'tab1')
                <div style="border-bottom: 1px solid black !important;">
                    <div class="row">
                        <div class="col-6 d-grid gap-2">
                            <button type="button" class="btn btn-tab btn-block" wire:click="cambioTab('tab1')">Consultar
                                trabajos realizados</button>
                        </div>
                        <div class="ms-auto col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block" wire:click="cambioTab('tab3')">Editar
                                tarea</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="ms-auto col d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab4')">Opciones</button>
                        </div>
                    </div>
                    <br>
                </div>
                <br>

                @livewire('trabajos-realizar.index-component')
            @elseif ($tab == 'tab3')
                <div style="border-bottom: 1px solid black !important;">
                    <div class="row">
                        <div class="col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab1')">Consultar trabajos realizados</button>
                        </div>
                        <div class="ms-auto col-6 d-grid gap-2">
                            <button type="button" class="btn btn-tab btn-block" wire:click="cambioTab('tab3')">Editar
                                tarea</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="ms-auto col d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab4')">Opciones</button>
                        </div>
                    </div>
                    <br>
                </div>
                <br>

                @livewire('trabajos-realizar.edit-component', ['identificador' => $tarea], key('tab3'))
            @elseif ($tab == 'tab4')
                <div style="border-bottom: 1px solid black !important;">
                    <div class="row">
                        <div class="col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab1')">Consultar trabajos realizados</button>
                        </div>
                        <div class="ms-auto col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block" wire:click="cambioTab('tab3')">Editar
                                tarea</button>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="ms-auto col d-grid gap-2">
                            <button type="button" class="btn btn-tab btn-block"
                                wire:click="cambioTab('tab4')">Opciones</button>
                        </div>
                    </div>
                    <br>
                </div>
                <br>

                <div class="ms-auto col d-grid gap-2">
                    <a class="btn btn-tab btn-block" href="{{ route('proveedores.index') }}"> Consultar y editar
                        proveedores </a>
                    <a class="btn btn-tab btn-block" href="{{ route('ecotasa.index') }}"> Consultar y editar
                        ecotasas </a>
                </div>
            @endif
        @else
            @if ($tab == 'tab1')
                <div style="border-bottom: 1px solid black !important;">
                    <div>
                        <div class="row">
                            <div class="col-6 d-grid gap-2">
                                <button type="button" class="btn btn-tab btn-block"
                                    wire:click="cambioTab('tab1')">Consultar trabajos realizados</button>
                            </div>
                            <div class="ms-auto col-6 d-grid gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-block" disabled
                                    wire:click="cambioTab('tab3')">Editar tarea</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">

                            <div class="ms-auto col d-grid gap-2">
                                <button type="button" class="btn btn-outline-tab btn-block"
                                    wire:click="cambioTab('tab4')">Opciones</button>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <br>

                @livewire('trabajos-realizar.index-component')
            @elseif ($tab == 'tab4')
                <div style="border-bottom: 1px solid black !important;">
                    <div class="row">
                        <div class="col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab1')">Consultar trabajos realizados</button>
                        </div>
                        <div class="ms-auto col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-block" wire:click="cambioTab('tab3')" disabled>Editar
                                tarea</button>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="ms-auto col d-grid gap-2">
                            <button type="button" class="btn btn-tab btn-block"
                                wire:click="cambioTab('tab4')">Opciones</button>
                        </div>
                    </div>
                    <br>
                </div>

                <br>

                <div class="ms-auto col d-grid gap-2">
                    <a class="btn btn-tab btn-block" href="{{ route('trabajadores.index') }}"> Consultar y
                        editar proveedores </a>
                </div>
            @endif
        @endif
    @elsemobile
        @if ($tarea != null)
            @if ($tab == 'tab1')
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <button class="nav-link active" wire:click.prevent="cambioTab('tab1')">
                            <h3>Consultar trabajos realizados</h3>
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab3')">
                            <h5> Editar tarea</h5>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab4')">
                            <h5> Opciones</h5>
                        </button>
                    </li>
                </ul>

                @livewire('trabajos-realizar.index-component')
            @elseif ($tab == 'tab3')
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab1')">
                            <h5> Consultar trabajos realizados</h5>
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link active" wire:click.prevent="cambioTab('tab3')">
                            <h3>Editar tarea</h3>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab4')">
                            <h5> Opciones </h5>
                        </button>
                    </li>
                </ul>
                <br>

                @livewire('trabajos-realizar.edit-component', ['identificador' => $tarea], key('tab3'))
            @elseif ($tab == 'tab4')
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab1')">
                            <h5> Consultar trabajos realizados
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab3')">
                            <h5> Editar tarea</h5>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link active" wire:click.prevent="cambioTab('tab4')">
                            <h3>Opciones</h3>
                        </button>
                    </li>
                </ul>
                <br>

                <div class="ms-auto col d-grid gap-2">
                    <a class="btn btn-tab btn-lg" href="{{ route('proveedores.index') }}"> Consultar y editar
                        proveedores </a>
                    <a class="btn btn-tab btn-lg" href="{{ route('ecotasa.index') }}"> Consultar y editar
                        ecotasas </a>
                </div>
            @endif
        @else
            @if ($tab == 'tab1')
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <button class="nav-link active" wire:click.prevent="cambioTab('tab1')">
                            <h3> Consultar trabajos realizados </h3>
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab3')" disabled>
                            <h5> Editar tarea </h5>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab4')">
                            <h5> Opciones </h5>
                        </button>
                    </li>
                </ul>
                <br>
                @livewire('trabajos-realizar.index-component')
            @elseif ($tab == 'tab4')
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab1')">
                            <h5> Consultar trabajos realizados </h5>
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab3')" disabled>
                            <h5> Editar tarea </h5>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link active" wire:click.prevent="cambioTab('tab4')">
                            <h3> Opciones </h3>
                        </button>
                    </li>
                </ul>
                <br>

                <div class="ms-auto col d-grid gap-2">
                    <a class="btn btn-tab btn-lg" href="{{ route('trabajadores.index') }}"> Consultar y
                        editar trabajadores </a>
                </div>
            @endif
        @endif
    @endmobile

</div>
