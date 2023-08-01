<?php

namespace App\Http\Livewire\TrabajosRealizar;

use App\Models\PartesTrabajo;
use App\Models\Trabajo;
use App\Models\Trabajador;
use App\Models\Clients;
use App\Models\Presupuesto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;

class IndexComponent extends Component
{
    // public $search;
    public $tareas;
    public $tareaSel;
    public $tareaMostrar;
    public $clientes;
    public $trabajadores;

    public $pagina;
    public $porPagina = 10;
    protected $tabla;

    public function mount()
    {
        $this->tareas = Trabajo::all();
        $this->clientes = Clients::all();
        $this->trabajadores = Trabajador::all();
        if (count($this->tareas) > 0) {
            $this->tareaSel = $this->tareas->last()->id;
        }
    }

    public function seleccionarProducto($id)
    {
        $this->emit("seleccionarProducto", $id);
    }


    public function render()
    {
        $this->tareaMostrar = $this->tareas->find($this->tareaSel);
        return view('livewire.trabajos-realizar.index-component');
    }

    public function pagination(Collection $data)
    {
        $items = $data->forPage($this->pagina, $this->porPagina);
        $totalResults = $data->count();

        return new LengthAwarePaginator(
            $items,
            $totalResults,
            $this->porPagina,
            $this->pagina,
            // Esta parte (options) la copie de lo que hace por defecto el paginador de Laravel haciendo un dd()
            [
                'path' => url()->current(),
                'pageName' => 'pagina',
            ]
        );
    }

    public function completarTarea($id)
    {
        $tarea = Trabajo::find($id);
        $tarea->estado = "Completada";
        $tarea->save();

        $tareas = Trabajo::where('parte_id', $tarea->parte_id)->get();
        $contador_completadas = 0;

        foreach ($tareas as $tarea) {
            if ($tarea->estado == 'Completada') {
                $contador_completadas++;
            }
        }

        if ($contador_completadas == $tareas->count()) {
            $parte = PartesTrabajo::find($tarea->parte_id);
            $parte->estado = "Completada";
            $parte->save();
        }

        return redirect(request()->header('Referer'));
    }

    public function devolverTarea($id)
    {
        $tarea = Trabajo::find($id);
        $tarea->estado = "Asignada";
        $tarea->save();
        return redirect(request()->header('Referer'));
    }
}
