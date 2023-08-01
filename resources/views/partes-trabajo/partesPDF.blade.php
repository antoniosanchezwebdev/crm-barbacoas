<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        .container {
            width: 100%;
            padding: 15px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1rem;

        }

        .row {
            clear: both;
            margin-top: 10px;
            margin-left: auto;
        }

        .row .label {
            float: left;
            width: 25%;
            font-weight: bold;
        }

        .row .value {
            float: left;
            width: 75%;
        }

        .signature {
            margin-top: 50px;
        }

        .signature img {
            max-width: 200px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .totals {
            float: right;
            width: 30%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .totals th,
        .totals td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ public_path('images/android-chrome-192x192.png') }}" alt="Firma del Cliente"
            style="display: float; float: left;">

        <div class="header">
            <h2>Documento de Parte de Trabajo</h2>
        </div>
        <br>
        <br>

        <div class="row">
            <div class="label">Fecha:</div>
            <div class="value">{{ substr($parte->fecha, 0, 10) }}</div>
        </div>

        <div class="row">
            <div class="label">Cliente:</div>
            <div class="value">{{ $cliente->nombre }}</div>
        </div>

        <div class="row">
            <div class="label">Trabajo solicitado:</div>
            <div class="value">{{ $parte->titulo }}</div>
        </div>

        <div class="row">
            <div class="label">Comentarios:</div>
            <div class="value">Buenos días</div>
        </div>

        <br>
        <br>
        <br>
        <br>

        <table class="table">
            <thead>
                <tr>
                    <th>Trabajo</th>
                    <th>Operario</th>
                    <th>Tiempo</th>
                    <th>Materiales</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trabajos_realizar as $tarea)
                    <tr>
                        <td>{{ $tarea['titulo'] }}</td>
                        <td>{{ $tarea['descripcion'] }}</td>
                        <td>{{ $tarea['horas_estimadas'] }}</td>
                        <td><ul>@foreach(json_decode($tarea['materiales'], true) as $material)
                            <li>{{$material['titulo']}} x {{$material['cantidad']}} - {{$material['precio']}}</li>@endforeach</ul>
                        <td>{{ $tarea['precio'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals">
            <tr>
                <th>Subtotal</th>
                <td>{{$subtotal}}</td>
            </tr>
            <tr>
                <th>IVA</th>
                <td>{{$iva}}</td>
            </tr>
            <tr>
                <th>Precio Total</th>
                <td>{{ $parte->precio }}</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br><br>
        <br>
        <br>
        <br>
        <div class="signature">
            <p>Firma del Cliente:</p>
            <img src="{{ public_path('storage/' . $parte->firma) }}" alt="Firma del Cliente">

        </div>
    </div>
</body>

</html>
