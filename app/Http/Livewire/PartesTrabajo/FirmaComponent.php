<?php

namespace App\Http\Livewire\PartesTrabajo;

use App\Models\Clients;
use App\Models\PartesTrabajo;
use App\Models\Trabajo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class FirmaComponent extends Component
{
    public $parte_id;
    protected $listeners = ['saveSignature'];

    public function mount($parte_id)
    {
        $this->parte_id = $parte_id;
    }
    public function render()
    {
        return view('livewire.partes-trabajo.firma-component');
    }

    public function saveSignature($signatureData)
    {
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData));

        $imageName = Str::random(10) . '.' . "png";

        $rutaDirectorio = 'firmas_cliente/';

        // Crea el directorio si no existe
        if (!File::exists(public_path($rutaDirectorio))) {
            File::makeDirectory(public_path($rutaDirectorio), 0777, true);
        }

        Storage::disk('public')->put($rutaDirectorio . '/' . $imageName, $data);

        $path = $rutaDirectorio . $imageName;

        $parte = PartesTrabajo::find($this->parte_id);
        $parte->firma = $path;

        if ($path != 0) {
            $parte->estado = "Firmada";
        }

        $clientePDF = Clients::where('id', $parte->id_cliente)->first();
        $trabajos = Trabajo::where('parte_id', $this->parte_id)->get();
        $trabajos_realizar = [];
        $subtotal = 0;

        foreach($trabajos as $trabajo){
            $trabajos_realizar[] = ['titulo' => $trabajo->titulo, 'descripcion' => $trabajo->descripcion, 'horas_estimadas' => intval(explode(':', $trabajo->tiempo_estimado)[0]), 'precio' => $trabajo->precio, 'materiales' => $trabajo->materiales];
            $subtotal += $trabajo->precio;
        }
        $iva = (string) ((($parte->precio / $subtotal) - 1) * 100);;


        $pdf = Pdf::loadView('partes-trabajo.partesPDF', ['trabajos_realizar' => $trabajos_realizar, 'iva' => $iva, 'subtotal' => $subtotal,
        'cliente' => $clientePDF, 'parte' => $parte]);

        // Ruta del directorio donde se guardará el archivo
        $rutaDirectorio = 'partes-trabajo-docs/';

        // Crea el directorio si no existe
        if (!File::exists(public_path($rutaDirectorio))) {
            File::makeDirectory(public_path($rutaDirectorio), 0777, true);
        }

        // Ruta del archivo PDF
        $rutaPdf = $rutaDirectorio . $clientePDF->id . "-" . $parte->id . '.pdf';

        // Guarda el PDF en un archivo en el servidor.
        $pdf->save($rutaPdf, 'public');

        // Añade la ruta del PDF a los datos validados.
        $parte->documentos = $rutaPdf;

        $parte->save();

        return redirect(request()->header('Referer'));
    }
}
