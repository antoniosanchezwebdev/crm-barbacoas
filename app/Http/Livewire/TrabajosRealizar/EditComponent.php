<?php

namespace App\Http\Livewire\TrabajosRealizar;

use App\Models\Presupuesto;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Clients;
use App\Models\PartesTrabajo;
use App\Models\Trabajo;
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
    public $titulo;
    public $descripcion;
    public $trabajador_id;
    public $parte_id;
    public $tiempo_estimado;
    public $estado;
    public $tiempo_real;
    public $materiales = [];
    public $materialesAux = [];
    public $subtotal;
    public $iva;
    public $precio;


    public $operarios;
    public $trabajadores;


    public function mount()
    {
        $this->tarea = Trabajo::find($this->identificador);
        $this->operarios = json_decode(PartesTrabajo::where('id', $this->tarea->parte_id)->first()->operarios, true);
        $this->materialesAux = json_decode($this->tarea->materiales, true);
        $this->trabajadores = User::whereIn('id', $this->operarios)->get();
        $this->titulo = $this->tarea->titulo;
        $this->descripcion = $this->tarea->descripcion;
        $this->trabajador_id = $this->tarea->trabajador_id;
        $this->parte_id = $this->tarea->parte_id;
        $this->precio = $this->tarea->precio;
        $this->tiempo_estimado = $this->tarea->tiempo_estimado;
        $this->estado = $this->tarea->estado;
        $this->tiempo_real = $this->tarea->tiempo_real;

        foreach ($this->materialesAux as $trabajo) {
            $precio_ind = ($trabajo['cantidad'] * $trabajo['precio']);
            $this->subtotal += $precio_ind;
        }
        $this->subtotal = round($this->subtotal, 2);

        $this->iva = (string) round(((($this->precio / $this->subtotal) - 1) * 100));
    }

    public function render()
    {
        return view('livewire.trabajos-realizar.edit-component');
    }

    // Al hacer update en el formulario
    public function update()
    {
        $this->estado = ($this->estado != null) ? $this->estado : 'Asignada';

        $this->materiales = array_merge($this->materialesAux, $this->materiales);
        $this->materialesAux = [];
        $this->generarSubtotal();

        // Validación de datos
        $this->validate(
            [
                'titulo' => 'required',
                'descripcion' => 'nullable',
                'trabajador_id' => 'required',
                'parte_id' => 'required',
                'tiempo_estimado' => 'required',
                'tiempo_real' => 'nullable',
                'estado' => 'required',
                'precio' => 'nullable',
                'materiales' => 'nullable',

            ],
            // Mensajes de error
            [
                'titulo.required' => 'El titulo es obligatorio.',
                'trabajador_id.required' => 'El ID del trabajador es obligatorio.',
                'parte_id.required' => 'El ID del parte de trabajo es obligatorio.',
                'tiempo_estimado.required' => 'El tiempo estimado del trabajo es obligatorio.',
                'estado.required' => 'El estado del trabajo es obligatorio.',
            ]
        );

        // Encuentra el identificador
        $presupuestos = Trabajo::find($this->identificador);

        // Guardar datos validados
        $presupuestosSave = $presupuestos->update([
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'trabajador_id' => $this->trabajador_id,
            'parte_id' => $this->parte_id,
            'tiempo_estimado' => $this->tiempo_estimado,
            'tiempo_real' => $this->tiempo_real,
            'precio' => $this->precio,
            'estado' => $this->estado,
            'materiales' => json_encode($this->materiales),

        ]);

        $trabajos = Trabajo::where('parte_id', $this->parte_id)->get();
        $precioTotal = 0;
        $parte = PartesTrabajo::where('id', $this->parte_id)->first();

        foreach($trabajos as $trabajo){
            $precioTotal += $trabajo->precio;
        }

        $parte->precio = $precioTotal;
        $parte->save();


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

    public function confirmed()
    {
        // Do something
        return redirect()->route('trabajos-realizar.index');
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

    public function generarSubtotal()
    {
        $this->subtotal = 0;
        if (!empty($this->materialesAux)) {
            foreach ($this->materialesAux as $trabajo) {
                $precio_ind = ($trabajo['cantidad'] * $trabajo['precio']);
                $this->subtotal += $precio_ind;
            }
        }

        foreach ($this->materiales as $trabajo) {
            $precio_ind = ($trabajo['cantidad'] * $trabajo['precio']);
            $this->subtotal += $precio_ind;
        }

        $this->subtotal = round($this->subtotal, 2);

        if ($this->iva != 0) {
            $this->precio = round(($this->subtotal + ($this->subtotal * ($this->iva / 100))), 2);
        } else {
            $this->precio =  $this->subtotal;
        }
    }

    public function addTrabajo()
    {
        $this->materiales[] = ['nombre' => '', 'cantidad' => 1, 'precio' => 0];
    }

    public function deleteTrabajo($indice)
    {
        unset($this->materiales[$indice]);
        $this->materiales = array_values($this->materiales);
        $this->generarSubtotal();
    }

    public function alertaTrabajo($indice)
    {
        unset($this->materialesAux[$indice]);
        $this->materialesAux = array_values($this->materialesAux);
        $this->generarSubtotal();
    }
}
