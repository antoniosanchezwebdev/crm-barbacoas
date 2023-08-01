<?php

namespace App\Http\Livewire\TrabajosRealizar;

use Livewire\Component;

class TareasComponent extends Component
{
    public $tab = "tab1";
    public $tarea;
    protected $listeners = ['seleccionarProducto' => 'selectProducto'];

    public function render()
    {
        return view('livewire.trabajos-realizar.tareas-component');
    }
    public function cambioTab($tab){
        $this->tab = $tab;
    }
    public function selectProducto($tarea){
        $this->tarea = $tarea;
        $this->tab = "tab3";
    }
}
