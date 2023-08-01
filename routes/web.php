<?php

use App\Http\Controllers\FabricantesController;
use App\Http\Controllers\TrabajosRealizarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BudgetReferenceAutopincrementsController;
use App\Http\Controllers\BudgetStatuController;
use App\Http\Controllers\ClientsEmailController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectPriorityController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PartesTrabajoController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\EcotasaController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\IvaController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\InformesController;
use App\Http\Controllers\ProductosCategoriesController;
use App\Http\Livewire\Facturas\EditComponent;
use App\Http\Livewire\Facturas\IndexComponent as FacturasIndexComponent;
use App\Http\Livewire\Productos\IndexComponent;


// use App\Http\Middleware\IsAdmin;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('inicio')->get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients.index');

Route::group(['middleware' => 'is.admin', 'prefix' => 'admin'], function () {

    /* --------------------------------------- */


    // RECORDATORIO: IMPORTAR CONTROLADORES NUEVOS

    Route::get('trabajadores', [TrabajadorController::class, 'index'])->name('trabajadores.index');
    Route::get('trabajadores-create', [TrabajadorController::class, 'create'])->name('trabajadores.create');
    Route::get('trabajadores-edit/{id}', [TrabajadorController::class, 'edit'])->name('trabajadores.edit');

    Route::get('partes-trabajo', [PartesTrabajoController::class, 'index'])->name('partes-trabajo.index');
    Route::get('partes-trabajo-create/{id}', [PartesTrabajoController::class, 'create'])->name('partes-trabajo.create');
    Route::get('partes-trabajo-edit/{id}', [PartesTrabajoController::class, 'edit'])->name('partes-trabajo.edit');

    Route::get('trabajos-realizar', [TrabajosRealizarController::class, 'index'])->name('trabajos-realizar.index');
    Route::get('trabajos-realizar-create/{id}', [TrabajosRealizarController::class, 'create'])->name('trabajos-realizar.create');
    Route::get('trabajos-realizar-edit/{id}', [TrabajosRealizarController::class, 'edit'])->name('trabajos-realizar.edit');

    Route::get('clients', [ClientsController::class, 'index'])->name('clients.index');
    Route::get('clients/create', [ClientsController::class, 'create'])->name('clients.create');
    Route::get('clients/edit/{id}', [ClientsController::class, 'edit'])->name('clients.edit');




});
