<?php

use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\LibrosController;
use App\Http\Controllers\MoviliarioController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PrestamosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();
Route::view('/login', "auth.login")->name('login');
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
   // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/home', function () {
    return view('home/index');
})->middleware(['auth', 'verified'])->name('home');


// Route::get('/home', function () {
//     return view('home/index');
// })->middleware(['auth', 'verified'])->name('home');


// RUTAS PARA EL CONTROLADOR LIBROS
Route::get('/libros', [LibrosController::class, 'index'])->middleware('auth');
Route::get('/libros/selectEstante', [LibrosController::class, 'selectEstantes'])->middleware('auth');
Route::get('/libros/selectDivision', [LibrosController::class, 'selectDivisiones'])->middleware('auth');
Route::post('/libros/create', [LibrosController::class, 'store']);
Route::post('/libros/registrarEstante', [LibrosController::class, 'registrarEstante'])->middleware('auth');
Route::post('/libros/registrarDivision', [LibrosController::class, 'registrarDivision'])->middleware('auth');
Route::get('/libros/editar/{id}', [LibrosController::class, 'editar'])->middleware('auth');
Route::post('/libros/actualizar/{id}', [LibrosController::class, 'update'])->middleware('auth');
Route::get('/libros/eliminar/{id}', [LibrosController::class, 'destroy'])->middleware('auth');

// RUTAS PARA EL CONTROLADOR MOVILIARIO
Route::get('/moviliarios', [MoviliarioController::class,'index'])->middleware('auth');
Route::post('/moviliarios/create', [MoviliarioController::class,'store'])->middleware('auth');
Route::get('/moviliarios/listar/{id}', [MoviliarioController::class,'editar'])->middleware('auth');
Route::post('/moviliarios/actualizar/{id}', [MoviliarioController::class,'update'])->middleware('auth');
Route::get('/moviliarios/eliminar/{id}', [MoviliarioController::class,'destroy'])->middleware('auth');


// RUTAS PARA EL CONTROLAODR PRESTAMOS

Route::get('/prestamos', [PrestamosController::class, 'index'])->middleware('auth');
Route::get('/home', [PrestamosController::class, 'dashboard'])->middleware('auth');
//Route::get('/prestamos', [PrestamosController::class, 'actualizarEstadoDetalle']);
Route::post('/prestamos/createA', [PrestamosController::class, 'agregarPrestamoAlumno'])->middleware('auth');
Route::post('/prestamos/createPL', [PrestamosController::class, 'agregarPrestamoPL'])->middleware('auth');
Route::get('/prestamos/selectLibrosN', [PrestamosController::class, 'selectLibrosAlumnos'])->middleware('auth');
Route::get('/prestamos/selectLibrosNP', [PrestamosController::class, 'selectLibrosPersonal'])->middleware('auth');
Route::get('/prestamos/mobiliarios', [PrestamosController::class, 'selectMobiliarios'])->middleware('auth');
Route::get('/prestamos/verDetallesPA/{id}', [PrestamosController::class, 'verDetallesPrestamoA'])->middleware('auth');
Route::get('/prestamos/devolverPrestamoA/{id}', [PrestamosController::class, 'devolverPrestamoLibroA'])->middleware('auth');
Route::get('/prestamos/reportesPdf', [PrestamosController::class, 'reportesPdf'])->middleware('auth');


//RUTAS PARA EL CONTROALDOR DE ALUMNOS
Route::get('/alumnos', [AlumnosController::class, 'index'])->middleware('auth');
Route::get('/alumnos/editar/{id}', [AlumnosController::class, 'editar'])->middleware('auth');
Route::get('/alumnos/eliminar/{id}', [AlumnosController::class, 'destroy'])->middleware('auth');
Route::post('/alumnos/actualizar/{id}', [AlumnosController::class, 'update'])->middleware('auth');

//RUTAS PARA EL CONTROALDOR DE PERSONAL
Route::get('/personal', [PersonalController::class, 'index'])->middleware('auth');
Route::get('/personal/editar/{id}', [PersonalController::class, 'editar'])->middleware('auth');
Route::post('/personal/actualizar/{id}', [PersonalController::class, 'update'])->middleware('auth');

});
require __DIR__.'/../vendor/autoload.php';