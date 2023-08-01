<?php

namespace App\Http\Livewire;

use App\Models\TrabajoLog;
use App\Models\PartesTrabajo;
use App\Models\Trabajo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{

    public $tareas_en_curso;

    public $tareas;
    public $tab = "tab1";

    public $productos;

    public function mount()
    {
        $this->tareas = Trabajo::where('trabajador_id', Auth::user()->id)->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }

    public function iniciarTarea($tareaId, $trabajadorId)
    {
        if ($this->tareas->where('estado', 'En curso')->count() >= 1) {
            $tarea_detener = $this->tareas->where('estado', 'En curso')->first();
            $this->pausarTarea($tarea_detener->id, Auth::id());
        }

        $log = new TrabajoLog();

        $tarea = Trabajo::where('id', $tareaId)->first();
        $tarea->estado = "En curso";


        $log->trabajo_id = $tareaId;
        $log->trabajador_id = $trabajadorId;
        $log->fecha_inicio = Carbon::now();
        $log->fecha_fin = null;
        $log->estado = "En curso";

        $tarea->save();
        $log->save();

        return redirect(request()->header('Referer'));
    }

    public function pausarTarea($tareaId, $trabajadorId)
    {
        $tarea = Trabajo::where('id', $tareaId)->first();
        $tarea->estado = "Asignada";

        $log = TrabajoLog::where('trabajo_id', $tareaId)
            ->where('trabajador_id', $trabajadorId)
            ->where('estado', "En curso")
            ->whereNull('fecha_fin')
            ->orderBy('fecha_inicio', 'desc')
            ->first();

        if ($log) {
            $log->fecha_fin = Carbon::now();
            $log->estado = "Pausa";
            $log->save();
        }

        $tarea->save();


        return redirect(request()->header('Referer'));
    }

    public function calculoTiempo($logs)
    {
        $tiempo = 0;

        foreach ($logs as $log) {
            $start = new Carbon($log->fecha_inicio);
            $end = $log->fecha_fin ? new Carbon($log->fecha_fin) : Carbon::now();

            $tiempo += $end->diffInSeconds($start);
        }

        if ($tiempo >= 60) {
            $segundos = intval($tiempo % 60);
            $minutos = intval($tiempo / 60);
            if ($minutos >= 60) {
                $horas = intval($minutos / 60);
                $minutos = intval($minutos % 60);
            } else {
                $horas = "0";
            }
        } else {
            $horas = "0";
            $minutos = "0";
            $segundos = $tiempo;
        }
        if ($minutos < 10) {
            $minutos = "0" . $minutos;
        }

        if ($segundos < 10) {
            $segundos = "0" . $segundos;
        }

        if ($horas < 10) {
            $horas = "0" . $horas;
        }

        return $horas . ":" . $minutos . ":" . $segundos;
    }
    public function tiempoTotalTrabajado($tareaId, $trabajadorId)
    {
        $logs = TrabajoLog::where('trabajo_id', $tareaId)
            ->where('trabajador_id', $trabajadorId)
            ->get();

        $tiempo = 0;

        return $this->calculoTiempo($logs);
    }

    public function completarTarea($tareaId)
    {
        $tarea = Trabajo::find($tareaId);
        $tarea->estado = "Revisión";
        $tarea->save();
    }

    public function redirectToCaja($tarea, $metodo_pago)
    {
        session()->flash('tarea', $tarea);
        session()->flash('metodo_pago', $metodo_pago);

        return redirect()->route('caja.index');
    }

    public function cambioTab($tab)
    {
        $this->tab = $tab;
    }

    public function horasTrabajadasTotales($query)
    {
        switch ($query) {
            case 'hoy':
                $fechaObjetivoInicio = Carbon::now()->startOfDay();
                $fechaObjetivoFin = Carbon::now()->endOfDay();
                break;
            case 'ayer':
                $fechaObjetivoInicio = Carbon::yesterday()->startOfDay();
                $fechaObjetivoFin = Carbon::yesterday()->endOfDay();
                break;
            case 'mes':
                $fechaObjetivoInicio = Carbon::now()->startOfMonth();
                $fechaObjetivoFin = Carbon::now()->endOfMonth();
                break;
            case 'semana':
                $fechaObjetivoInicio = Carbon::now()->startOfWeek();
                $fechaObjetivoFin = Carbon::now()->startOfWeek()->addDays(4)->endOfDay();
                break;
            default:
                $fechaObjetivoInicio = Carbon::now()->startOfDay();
                $fechaObjetivoFin = Carbon::now()->endOfDay();
                break;
        }


        $entradas = TrabajoLog::where('fecha_inicio', '<=', $fechaObjetivoFin)
            ->where('fecha_fin', '>=', $fechaObjetivoInicio)
            ->get();

        sscanf($this->calculoTiempo($entradas), "%d:%d:%d", $horas, $minutos, $segundos);

        if ($horas > 0 && $minutos > 0 && $segundos == 0) {
            return "$horas horas y $minutos minutos";
        } elseif ($horas == 0 && $minutos > 0 && $segundos > 0) {
            return "$minutos minutos y $segundos segundos";
        } elseif ($horas > 0 && $minutos == 0 && $segundos > 0) {
            return "$horas horas y $segundos segundos";
        } else {
            return "Formato no reconocido";
        }
    }
}
