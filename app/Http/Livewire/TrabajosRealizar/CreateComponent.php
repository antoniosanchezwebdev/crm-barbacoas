<?php

namespace App\Http\Livewire\TrabajosRealizar;

use App\Models\Presupuesto;
use App\Models\Clients;
use App\Models\Trabajador;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\Trabajo;

class CreateComponent extends Component
{

    use LivewireAlert;

    public $titulo;
    public $fecha;
    public $id_cliente;
    public $trabajador_id;
    public $observaciones;
    public $trabajos_realizar = [['titulo' => '', 'descripcion' => '', 'horas_estimadas' => 0, 'precio' => 0]];
    public $operarios = [];
    public $descripcion;
    public $documentos;
    public $estado;
    public $firma;
    public $subtotal;
    public $iva;
    public $precio;


    public $clientes;
    public $trabajadores;



    public function mount()
    {
        $this->trabajadores = User::all(); // datos que se envian al select2
        $this->clientes = Clients::all(); // datos que se envian al select2

    }

    public function render()
    {
        return view('livewire.trabajos-realizar.create-component');
    }

    // Al hacer submit en el formulario
    public function submit()
    {
        $this->estado = "Asignado";
        $this->trabajos_realizar = json_encode($this->trabajos_realizar);
        $this->operarios = json_encode($this->operarios);
        $this->documentos = json_encode($this->documentos);

        // Validación de datos
        $validatedData = $this->validate(
            [
                'titulo' => 'required',
                'fecha' => 'required',
                'id_cliente' => 'required',
                'observaciones' => 'nullable',
                'trabajos_realizar' => 'required',
                'operarios' => 'required',
                'descripcion' => 'nullable',
                'documentos' => 'nullable',
                'estado' => 'required',
                'firma' => 'nullable',
                'precio' => 'required',
            ],
            // Mensajes de error
            [
                'titulo.required' => 'El número de presupuesto es obligatorio.',
                'fecha.required' => 'La fecha de emision es obligatoria.',
                'id_cliente.required' => 'El cliente es obligatorio.',
                'operarios.required' => 'La matricula del coche es obligatoria.',
                'precio.required' => 'Los kilometros del coche son obligatorios',
                'estado.required' => 'El trabajador es obligatorio.',
            ]
        );

        // Guardar datos validados
        $presupuesosSave = Trabajo::create($validatedData);

        $this->operarios = json_decode($this->operarios, true);
        $this->trabajos_realizar = json_decode($this->trabajos_realizar, true);
        $this->documentos = json_decode($this->documentos, true);

        foreach ($this->trabajos_realizar as $trabajos) {
            $trabajo = Trabajo::create([
                'titulo' => $trabajos['titulo'],
                'descripcion' => $trabajos['descripcion'],
                'trabajador_id' => 0,
                'parte_id' => $presupuesosSave->id,
                'tiempo_estimado' => Carbon::createFromFormat('H', $trabajos['horas_estimadas'],)->format('H:i:s'),
                'tiempo_real' => Carbon::createFromFormat('H', 0,)->format('H:i:s'),
            ]);
        }



        // Alertas de guardado exitoso
        if ($presupuesosSave) {
            $this->alert('success', '¡Parte de trabajo registrado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del parte de trabajo!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
            'calcularPrecio',
            'listarAlmacen',
            'numeroPresupuesto',
            'añadirProducto',
            'reducir',
            'precioFinal',
            'seleccionarProducto',
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('trabajos-realizar.index');
    }

    public function addTrabajo()
    {
        $this->trabajos_realizar[] = ['titulo' => '', 'descripcion' => '', 'horas_estimadas' => 0, 'precio' => 0];
    }

    public function generarSubtotal()
    {
        $this->subtotal = 0;
        foreach ($this->trabajos_realizar as $trabajo) {
            $this->subtotal += $trabajo['precio'];
        }

        $this->subtotal == $this->subtotal . '€';

        if ($this->iva != 0) {
            $this->precio = $this->subtotal + ($this->subtotal * ($this->iva / 100));
        }
    }

    public function addTrabajador()
    {
        if ($this->trabajador_id != null) {
            if (!empty($this->operarios)) {
                if (!in_array($this->trabajador_id, $this->operarios)) {
                    $this->operarios[] = (int) $this->trabajador_id;
                } else {
                    $this->alert('warning', 'Este operario ya está asignado');
                }
            } else {
                $this->operarios = [(int) $this->trabajador_id];
            }
        }
    }
}
