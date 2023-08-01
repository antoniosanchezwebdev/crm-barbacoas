<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>
<style>
    /* Media Query para partesadores con pantallas grandes */
    @media (min-width: 600px) {
        .img-fluid {
            max-height: 25% !important;
            max-width: 25% !important;
        }

        li {
            margin-right: 10px;
        }

    }

    /* Media Query para tablets y móviles */
    @media (max-width: 500px) {
        .img-fluid {
            max-height: 50% !important;
            max-width: 50% !important;
        }

        li {
            margin-bottom: 10px;
        }
    }

    body {
        background-color: #d9d9d9;
    }

    .btn-light{
        color: #b90c18 !important;
    }
    .btn-outline-light:hover{
        background-color: #fff;
        color: #b90c18 !important;
    }
    .navbar-toggler{

    }
</style>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg shadow " style="background-color:#b90c18 !important;">
    @mobile
        <div class="container-fluid">
            <div class="navbar-brand">
                <a href="/../home/"><img src="{{ asset('images/logo.png') }}" style="max-width: 35% !important;" alt="Logo"></a>
                <button class="navbar-toggler float-end mt-4 border-white border-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav justify-content-around w-100 py-2">
                    <li class="nav-item mx-2">
                        @if (Request::is('admin/partes-trabajo'))
                            <a class="btn w-100 btn-md btn-light d-block w-100 p-2" href="/admin/partes-trabajo">
                                <i class="fas fa-book"></i><br>
                                <strong>Partes de trabajo</strong>
                            </a>
                        @else
                            <a class="btn w-100 btn-md btn-outline-light d-block w-100 p-2" href="/admin/partes-trabajo">
                                <i class="fas fa-book"></i><br>
                                <strong>Partes de trabajo</strong>
                            </a>
                        @endif
                    </li>
                    <li class="nav-item mx-2">
                        @if (Request::is('admin/trabajos-realizar'))
                            <a class="btn w-100 btn-md btn-light d-block w-100 p-2" href="/admin/trabajos-realizar">
                                <i class="fas fa-gears"></i><br>
                                <strong>Trabajos realizados</strong>
                            </a>
                        @else
                            <a class="btn w-100 btn-md btn-outline-light d-block w-100 p-2" href="/admin/trabajos-realizar">
                                <i class="fas fa-gears"></i><br>
                                <strong>Trabajos realizados</strong>
                            </a>
                        @endif
                    </li>
                    <li class="nav-item mx-2">
                        @if (Request::is('admin/clients'))
                            <a class="btn w-100 btn-md btn-light d-block w-100 p-2" href="/admin/clients">
                                <i class="fas fa-users"></i><br>
                                <strong>Clientes</strong>
                            </a>
                        @else
                            <a class="btn w-100 btn-md btn-outline-light d-block w-100 p-2" href="/admin/clients">
                                <i class="fas fa-users"></i><br>
                                <strong>Clientes</strong>
                            </a>
                        @endif
                    </li>
                    <li class="nav-item mx-2">
                        @if (Request::is('admin/trabajadores'))
                            <a class="btn w-100 btn-md btn-light d-block w-100 p-2" href="/admin/trabajadores">
                                <i class="fas fa-people-carry-box"></i><br>
                                <strong>Trabajadores</strong>
                            </a>
                        @else
                            <a class="btn w-100 btn-md btn-outline-light d-block w-100 p-2" href="/admin/trabajadores">
                                <i class="fas fa-people-carry-box"></i><br>
                                <strong>Trabajadores</strong>
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    @elsemobile
        <div class="container-fluid col-12">
            <div class="navbar-brand col order-1">
                <a href="/../home/"><img src="{{ asset('images/logo.png') }}" style="margin-left: 50px; max-width: 15% !important;" alt="Logo"></a>
            </div>
            <ul class="navbar-nav nav-fill me-auto mb-0 mb-lg-0 col order-2">
                <li class="nav-item">
                    @if (Request::is('admin/partes-trabajo'))
                        <a class="btn w-100 btn-light text-dark" href="/admin/partes-trabajo">
                            <i class="fas fa-book"></i><br>
                            <strong>Partes de trabajo</strong>
                        </a>
                    @else
                        <a class="btn w-100 btn-outline-light" href="/admin/partes-trabajo">
                            <i class="fas fa-book"></i><br>
                            <strong>Partes de trabajo</strong>
                        </a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (Request::is('admin/trabajos-realizar'))
                        <a class="btn w-100 btn-light text-dark" href="/admin/trabajos-realizar">
                            <i class="fas fa-gears"></i><br>
                            <strong>Trabajos realizados</strong>
                        </a>
                    @else
                        <a class="btn w-100 btn-outline-light" href="/admin/trabajos-realizar">
                            <i class="fas fa-gears"></i><br>
                            <strong>Trabajos realizados</strong>
                        </a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (Request::is('admin/clients'))
                        <a class="btn w-100 btn-light text-dark" href="/admin/clients">
                            <i class="fas fa-users"></i><br>
                            <strong>Clientes</strong>
                        </a>
                    @else
                        <a class="btn w-100 btn-outline-light" href="/admin/clients">
                            <i class="fas fa-users"></i><br>
                            <strong>Clientes</strong>
                        </a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (Request::is('admin/trabajadores'))
                        <a class="btn w-100 btn-light text-dark" href="/admin/trabajadores">
                            <i class="fas fa-people-carry-box"></i><br>
                            <strong>Trabajadores</strong>
                        </a>
                    @else
                        <a class="btn w-100 btn-outline-light" href="/admin/trabajadores">
                            <i class="fas fa-people-carry-box"></i><br>
                            <strong>Trabajadores</strong>
                        </a>
                    @endif
                </li>
                <li class="nav-item">
                    &nbsp;
                </li>
                <li class="nav-item">
                    &nbsp;
                </li>
                <li class="nav-item">
                    &nbsp;
                </li>
            </ul>
        </div>
        </div>
    @endmobile
</nav>
