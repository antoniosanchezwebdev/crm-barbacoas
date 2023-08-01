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
        @if ($cliente != null)
            @if ($tab == 'tab1')
                <div style="border-bottom: 1px solid black !important;">
                    <div class="row">
                        <div class="col-6 d-grid gap-2">
                            <button type="button" class="btn btn-tab btn-block" wire:click="cambioTab('tab1')">Consultar
                                clientes</button>
                        </div>
                        <div class="ms-auto col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab2')">Ver/Editar
                                cliente</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="me-auto col d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab3')">Añadir
                                cliente</button>
                        </div>
                    </div>
                    <br>
                </div>
                <br>

                @livewire('client-component')
            @elseif ($tab == 'tab2')
                <div style="border-bottom: 1px solid black !important;">
                    <div class="row">
                        <div class="col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab1')">Consultar clientes</button>
                        </div>
                        <div class="ms-auto col-6 d-grid gap-2">
                            <button type="button" class="btn btn-tab btn-block"
                                wire:click="cambioTab('tab2')">Ver/Editar
                                cliente</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="me-auto col d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab3')">Añadir
                                cliente</button>
                        </div>

                    </div>
                    <br>
                </div>
                <br>

                @livewire('clients.edit-component', ['identificador' => $cliente], key('tab2'))

                <br>
            @elseif ($tab == 'tab3')
                <div style="border-bottom: 1px solid black !important;">
                    <div class="row">
                        <div class="col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab1')">Consultar clientes</button>
                        </div>
                        <div class="ms-auto col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab2')">Ver/Editar
                                cliente</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="me-auto col d-grid gap-2">
                            <button type="button" class="btn btn-tab btn-block" wire:click="cambioTab('tab3')">Añadir
                                cliente</button>
                        </div>

                    </div>
                    <br>
                </div>
                <br>
                @livewire('clients.create-component', key('tab3'))
            @endif
        @else
            @if ($tab == 'tab1')
                <div style="border-bottom: 1px solid black !important;">
                    <div>
                        <div class="row">
                            <div class="col-6 d-grid gap-2">
                                <button type="button" class="btn btn-tab btn-block"
                                    wire:click="cambioTab('tab1')">Consultar clientes</button>
                            </div>
                            <div class="ms-auto col-6 d-grid gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-block" disabled
                                    wire:click="cambioTab('tab2')">Ver/Editar
                                    cliente</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="me-auto col d-grid gap-2">
                                <button type="button" class="btn btn-outline-tab btn-block"
                                    wire:click="cambioTab('tab3')">Añadir
                                    cliente</button>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <br>

                @livewire('client-component')
            @elseif ($tab == 'tab3')
                <div style="border-bottom: 1px solid black !important;">
                    <div class="row">
                        <div class="col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-tab btn-block"
                                wire:click="cambioTab('tab1')">Consultar clientes</button>
                        </div>
                        <div class="ms-auto col-6 d-grid gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-block"
                                wire:click="cambioTab('tab2')" disabled>Ver/Editar
                                cliente</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="me-auto col d-grid gap-2">
                            <button type="button" class="btn btn-tab btn-block" wire:click="cambioTab('tab3')">Añadir
                                cliente</button>
                        </div>
                    </div>
                    <br>
                </div>
                <br>

                    @livewire('clients.create-component')
                <br>
            @endif
        @endif
    @elsemobile
        @if ($cliente != null)
            @if ($tab == 'tab1')
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <button class="nav-link active" wire:click.prevent="cambioTab('tab1')">
                            <h3>Consultar clientes</h3>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab2')">
                            <h5>Ver/Editar
                                cliente</h5>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab3')">
                            <h5>Añadir
                                cliente</h5>
                        </button>
                    </li>
                </ul>
                <br>

                @livewire('client-component')
            @elseif ($tab == 'tab2')
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab1')">
                            <h5>Consultar clientes</h5>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link active" wire:click.prevent="cambioTab('tab2')">
                            <h3>Ver/Editar
                                cliente</h3>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab3')">
                            <h5>Añadir
                                cliente</h5>
                        </button>
                    </li>
                </ul>
                <br>

                @livewire('clients.edit-component', ['identificador' => $cliente], key('tab2'))

                <br>
            @elseif ($tab == 'tab3')
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab1')">
                            <h5>Consultar clientes</h5>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab2')">
                            <h5>Ver/Editar
                                cliente</h5>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link active" wire:click.prevent="cambioTab('tab3')">
                            <h3>Añadir
                                cliente</h3>
                        </button>
                    </li>
                </ul>
                <br>

                @livewire('clients.create-component', key('tab3'))
            @endif
        @else
            @if ($tab == 'tab1')
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <button class="nav-link active" wire:click.prevent="cambioTab('tab1')">
                            <h3>Consultar clientes</h3>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab2')" disabled>
                            <h5>Ver/Editar
                                cliente</h5>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab3')">
                            <h5>Añadir
                                cliente</h5>
                        </button>
                    </li>
                </ul>
                <br>

                @livewire('client-component')
            @elseif ($tab == 'tab3')
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab1')">
                            <h5>Consultar clientes</h5>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" wire:click.prevent="cambioTab('tab2')" disabled>
                            <h5>Ver/Editar
                                cliente</h5>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link active" wire:click.prevent="cambioTab('tab3')">
                            <h3>Añadir
                                cliente</h3>
                        </button>
                    </li>
                </ul>
                <br>
                @livewire('clients.create-component', key('tab3'))
                <br>
            @endif
        @endif
    @endmobile

</div>
