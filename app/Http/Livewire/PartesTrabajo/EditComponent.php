<?php

namespace App\Http\Livewire\PartesTrabajo;

use App\Models\Presupuesto;
use App\Models\Trabajo;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Clients;
use App\Models\PartesTrabajo;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\Productos;
use App\Models\Trabajador;
use Livewire\WithFileUploads;


class EditComponent extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $identificador;
    public $tarea;
    public $fecha;
    public $id_cliente;
    public $trabajador_id;
    public $observaciones;
    public $trabajos_realizar = [];
    public $trabajos_realizarAux = [];

    public $operarios = [];
    public $descripcion;
    public $documentos;
    public $estado;
    public $firma;
    public $subtotal;
    public $iva;
    public $titulo;
    public $precio;

    public $trabajadores;
    public $clientes;
    public $trabajos;


    public function mount()
    {
        $this->tarea = PartesTrabajo::find($this->identificador);


        $this->trabajadores = User::all(); // datos que se envian al select2
        $this->clientes = Clients::all(); // datos que se envian al select2
        $this->trabajos = Trabajo::where('parte_id', $this->identificador)->get();

        $this->titulo = $this->tarea->titulo;
        $this->fecha = $this->tarea->fecha;
        $this->id_cliente = $this->tarea->id_cliente;
        $this->trabajador_id = $this->tarea->trabajador_id;
        $this->observaciones = $this->tarea->observaciones;
        $this->operarios = json_decode($this->tarea->operarios, true);
        $this->descripcion = $this->tarea->descripcion;
        $this->documentos = json_decode($this->tarea->documentos, true);
        $this->estado = $this->tarea->estado;
        $this->firma = $this->tarea->firma;
        $this->precio = $this->tarea->precio;

        foreach ($this->trabajos as $trabajo) {
            $this->trabajos_realizarAux[] = ['titulo' => $trabajo->titulo, 'descripcion' => $trabajo->descripcion, 'horas_estimadas' => intval(explode(':', $trabajo->tiempo_estimado)[0]), 'precio' => $trabajo->precio];
        }

        foreach ($this->trabajos_realizarAux as $trabajo) {
            $this->subtotal += $trabajo['precio'];
        }

        $this->iva = (string) ((($this->precio / $this->subtotal) - 1) * 100);
    }

    public function render()
    {
        return view('livewire.partes-trabajo.edit-component');
    }

    // Al hacer update en el formulario
    public function update()
    {
        $trabajosNuevos = $this->trabajos_realizar;

        $this->trabajos_realizar = array_merge($this->trabajos_realizarAux, $this->trabajos_realizar);
        $this->trabajos_realizarAux = [];
        $this->generarSubtotal();

        $this->trabajos_realizarAux = $trabajosNuevos;


        $this->estado = ($this->estado != null) ? $this->estado : 'Asignada';
        $this->trabajos_realizar = json_encode($this->trabajos_realizar);
        $this->operarios = json_encode($this->operarios);
        $this->documentos = json_encode($this->documentos);

        // Validación de datos
        $this->validate(
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
        // Encuentra el identificador
        $presupuestos = PartesTrabajo::find($this->identificador);


        // Guardar datos validados
        $presupuestosSave = $presupuestos->update([
            'titulo' => $this->titulo,
            'fecha' => $this->fecha,
            'id_cliente' => $this->id_cliente,
            'observaciones' => $this->observaciones,
            'trabajos_realizar' => $this->trabajos_realizar,
            'operarios' => $this->operarios,
            'descripcion' => $this->descripcion,
            'documentos' => $this->documentos,
            'estado' => $this->estado,
            'firma' => $this->firma,
            'precio' => $this->precio
        ]);

        $this->operarios = json_decode($this->operarios, true);
        $this->trabajos_realizar = json_decode($this->trabajos_realizar, true);
        $this->documentos = json_decode($this->documentos, true);

        foreach ($this->trabajos_realizarAux as $trabajos) {
            $trabajo = Trabajo::create([
                'titulo' => $trabajos['titulo'],
                'descripcion' => $trabajos['descripcion'],
                'trabajador_id' => 0,
                'parte_id' => $this->identificador,
                'tiempo_estimado' => $trabajos['horas_estimadas'] . ':00' . ':00',
                'tiempo_real' => '00:00:00',
                'precio' => $trabajos['precio'],

            ]);
        }

        if ($presupuestosSave) {
            $this->alert('success', '¡Tarea actualizada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información de la tarea!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }

        session()->flash('message', '¡Tarea actualizada correctamente!');

        $this->emit('productUpdated');
    }

    // Eliminación
    public function destroy()
    {

        $this->alert('warning', '¿Seguro que desea borrar la tarea? No hay vuelta atrás', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmDelete',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
            'confirmDelete'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('partes-trabajo.index');
    }

    public function generarSubtotal()
    {
        $this->subtotal = 0;
        if(!empty($this->trabajos_realizarAux)){
            foreach ($this->trabajos_realizarAux as $trabajo) {
                $this->subtotal += $trabajo['precio'];
            }
        }

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

    public function addTrabajo()
    {
        $this->trabajos_realizar[] = ['titulo' => '', 'descripcion' => '', 'horas_estimadas' => 0, 'precio' => 0];
    }

    public function deleteTrabajo($indice)
    {
        unset($this->trabajos_realizar[$indice]);
        $this->trabajos_realizar = array_values($this->trabajos_realizar);
    }

    public function alertaTrabajo()
    {
        $this->alert('warning', 'Este trabajo ya está guardado. Elimínalo desde su página.', ['width' => '50vw']);
    }

    public function deleteTrabajador($indice)
    {
        unset($this->operarios[$indice]);
        $this->operarios = array_values($this->operarios);
    }
}
