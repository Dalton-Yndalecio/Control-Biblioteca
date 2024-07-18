<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use App\Models\DetallesPrestamo;
use App\Models\Libros;
use App\Models\Moviliarios;
use App\Models\Objetos;
use App\Models\Personal;
use App\Models\Personas;
use App\Models\Prestamos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


use function Laravel\Prompts\alert;

class PrestamosController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function dashboard(Request $request){
        $libros = Libros::all();
        $cantidadLibros = $libros->count();

        $Mobiliarios = Moviliarios::all();
        $totalMobiliarios = $Mobiliarios->count();

        $prestamos = Prestamos::all();
        $totalPrestamos = $prestamos->count();

        $alumnos = Alumnos::all();
        $totalAlumnos = $alumnos->count();

        $personal = Personal::all();
        $totalPersonal = $personal->count();
    
        return view('home.index', ['cantidadLibros' => $cantidadLibros,
        'totalMobiliarios'=> $totalMobiliarios,
        'totalPrestamos'=> $totalPrestamos,
        'totalAlumnos'=> $totalAlumnos,
        'totalPersonal'=> $totalPersonal]);
    }
    public function index(Request $request)
    {   
        $detalles = DetallesPrestamo::all();
        $FechaA = now();

        foreach ($detalles as $detalle) {
            $FRetorno = $detalle->FRetorno;
            $PEstado = $detalle->PEstado;

            if ($FechaA > $FRetorno && $PEstado === 'Pendiente') {
                $detalle->update(['PEstado' => "Vencido"]);
            }
        }
        $mensajesNuevos = [];   
        if($request->ajax()){
            $prestamos = Prestamos::with(['personas'])->get();
            foreach ($prestamos as $prestamo) {
                $id = $prestamo->id;
                $estadosDP = [];
                $detallePrestamos = DetallesPrestamo::where('Id_prestamo', $id)->get();
                foreach ($detallePrestamos as $detalle) {
                    $estadosDP[] = $detalle->PEstado;
                }
                $conteoRegistros = count($detallePrestamos);
                $conteoEstados = array_count_values($estadosDP);
                $conteoPendiente = $conteoEstados['Pendiente'] ?? 0;
                $conteoEntregado = $conteoEstados['Entregado'] ?? 0;
                $conteoVencido = $conteoEstados['Vencido'] ?? 0;
                if ($conteoEntregado == $conteoRegistros) {
                    $mensaje = "Entregado $conteoEntregado de $conteoRegistros Préstamos";
                    $prestamo->update(['EstadoP' => "Entregado"]);
                } elseif ($conteoPendiente > 0 && $conteoEntregado > 0) {
                    $mensaje = " Entregado $conteoEntregado de $conteoRegistros Préstamos";
                }elseif ($conteoVencido > 0 && $conteoEntregado > 0) {
                    $mensaje = " Entregado $conteoEntregado de $conteoRegistros Préstamos";
                    $prestamo->update(['EstadoP' => "Vencido"]);
                } 
                 elseif ($conteoPendiente > 0) {
                    $mensaje = "Tiene $conteoRegistros Préstamos Pendientes";
                } elseif ($conteoVencido > 0) {
                    $mensaje = "Tiene $conteoRegistros Préstamos Vencidos";
                    $prestamo->update(['EstadoP' => "Vencido"]);
                }
                $mensajesNuevos[$id] = $mensaje;
                
               
            }
            
            return DataTables::of($prestamos)
                ->addColumn('personas', function ($matricula) {
                    return $matricula->personas->nombre . ' ' . $matricula->personas->apellidos;
                })
                ->addColumn('action', function($prestamos){
                    $editar = '<button class="btn btn-outline-info btn-sm btn-ver-detalles" data-id="' . $prestamos->id . '"><i class="far fa-eye"></i></button>';
                    return $editar;
                    
                })
                ->addColumn('mensajeNuevo', function ($prestamo) use ($mensajesNuevos) {
                    return $mensajesNuevos[$prestamo->id] ?? ''; // Accede al mensaje correspondiente al préstamo
                })
                    
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Prestamos.index');
    }
    
   public function selectLibrosAlumnos(Request $request)
   {

    $tipoLibro = $request->input('tipoObjeto');
    $libros = Libros::where('TipoLibro', $tipoLibro)->get();
    $libroIds = $libros->pluck('idobjeto');
    $objetos = Objetos::whereIn('id', $libroIds)->get();
    return response()->json($objetos);
   }
   
   public function selectLibrosPersonal(Request $request)
   {

    $tipoLibro = $request->input('tipoObjeto');
    $libros = Libros::where('TipoLibro', $tipoLibro)->get();
    $libroIds = $libros->pluck('idobjeto');
    $objetos = Objetos::whereIn('id', $libroIds)->get();
    return response()->json($objetos);
   }
   public function selectMobiliarios(Request $request)
   {
    $mobiliario = Moviliarios::all();
    $mobiliarioIds = $mobiliario->pluck('idobjeto');
    $objetos = Objetos::whereIn('id', $mobiliarioIds)->get();
    return response()->json($objetos);
   }

    /**
     * Store a newly created resource in storage.
     */
    public function agregarPrestamoAlumno(Request $request)
    {
        $detallesPrestamo = json_decode($request->input('detallesPrestamo'), true);
        $cantidadObjetos = count($detallesPrestamo['idObjeto']);
        $objetosSuficientes = true;
        foreach ($detallesPrestamo['idObjeto'] as $key => $idObjeto) {
            $cantidadPrestamo = $detallesPrestamo['cantidad'][$key];
            $objeto = Objetos::find($idObjeto);
            $nombre = $objeto->Nombre;
            if (!$objeto || $objeto->Cantidad < $cantidadPrestamo) {
                $objetosSuficientes = false;
                break; 
            }
        }
        if ($objetosSuficientes) {
            $persona = new Personas();
            $persona->nombre = $request->input('nombres');
            $persona->apellidos = $request->input('apellidos');
            $persona->save();

            $Id_persona = $persona->id;

            $alumno = new Alumnos();
            $alumno->idpersona = $Id_persona;
            $alumno->grado = $request->input('grado');
            $alumno->seccion = $request->input('seccion');
            $alumno->save();

            $prestamo = new Prestamos();
            $prestamo->idpersona = $Id_persona;
            $prestamo->cantidadObjetos = $cantidadObjetos;
            $prestamo->save();

            $IdPrestamo = $prestamo->id;
            
            foreach ($detallesPrestamo['idObjeto'] as $key => $idObjeto) {
                $cantidadPrestamo = $detallesPrestamo['cantidad'][$key];
                $objeto = Objetos::find($idObjeto);
            
                    $detalles = new DetallesPrestamo();
                    $detalles->Id_prestamo = $IdPrestamo;
                    $detalles->id_objeto = $idObjeto;
                    $detalles->cantidad = $cantidadPrestamo;
                    $detalles->FRetorno = $detallesPrestamo['FRetorno'][$key];
                    $detalles->OEstado = $detallesPrestamo['estado'][$key];
                    $detalles->save();
                    $objeto->Cantidad -= $cantidadPrestamo;
                    $objeto->save();
            }
            return response()->json(['success' => true, 'message' => 'Préstamo Registrado correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'No hay suficientes libros de '.$nombre.' ']);
        }    
    }
    public function agregarPrestamoPL(Request $request)
    {
        $detallesPrestamo = json_decode($request->input('detallesPrestamo'), true);
        $cantidadObjetos = count($detallesPrestamo['idObjeto']);
        $objetosSuficientes = true;
        foreach ($detallesPrestamo['idObjeto'] as $key => $idObjeto) {
            $cantidadPrestamo = $detallesPrestamo['cantidad'][$key];
            $objeto = Objetos::find($idObjeto);
            $nombre = $objeto->Nombre;
            if (!$objeto || $objeto->Cantidad < $cantidadPrestamo) {
                $objetosSuficientes = false;
                break; 
            }
        }
        if ($objetosSuficientes) {
            $persona = new Personas();
            $persona->nombre = $request->input('nombresPL');
            $persona->apellidos = $request->input('apellidosPL');
            $persona->save();

            $Id_persona = $persona->id;

            $personal = new Personal();
            $personal->idpersona = $Id_persona;
            $personal->Cargo = $request->input('cargoPL');
            $personal->Especialidad = $request->input('especialidadPL');
            $personal->Condición = $request->input('condicionPL');
            $personal->save();

            $prestamo = new Prestamos();
            $prestamo->idpersona = $Id_persona;
            $prestamo->cantidadObjetos = $cantidadObjetos;
            $prestamo->save();

            $IdPrestamo = $prestamo->id;
            
            foreach ($detallesPrestamo['idObjeto'] as $key => $idObjeto) {
                $cantidadPrestamo = $detallesPrestamo['cantidad'][$key];
                $objeto = Objetos::find($idObjeto);
            
                    $detalles = new DetallesPrestamo();
                    $detalles->Id_prestamo = $IdPrestamo;
                    $detalles->id_objeto = $idObjeto;
                    $detalles->cantidad = $cantidadPrestamo;
                    $detalles->FRetorno = $detallesPrestamo['FRetorno'][$key];
                    $detalles->OEstado = $detallesPrestamo['estado'][$key];
                    $detalles->save();
                    $objeto->Cantidad -= $cantidadPrestamo;
                    $objeto->save();
            }
            return response()->json(['success' => true, 'message' => 'Préstamo Registrado correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'No hay suficientes libros de '.$nombre.' ']);
        }    
    }

    /**
     * Display the specified resource.
     */
    public function verDetallesPrestamoA($id)
    {
        $detallesA = DB::select('CALL sp_verDetallesPrestamoAlumno(?)', [$id]);
        return response()->json($detallesA);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function devolverPrestamoLibroA($id)
    {
        $data = request()->all();
        $detalles = DetallesPrestamo::find($id);
        $cantidadDevuelta = $detalles->cantidad;

        // Convierte el estado completo a abreviatura
        $estadoObjeto = $data['estado'];
        $estadoAbreviado = '';

        if ($estadoObjeto === 'Bueno') {
            $estadoAbreviado = 'B';
        } elseif ($estadoObjeto === 'Regular') {
            $estadoAbreviado = 'R';
        } elseif ($estadoObjeto === 'Malo') {
            $estadoAbreviado = 'M';
        }

        // Actualiza los campos en DetallesPrestamo
        $detalles->update(['OEstado' => $estadoAbreviado]);
        $detalles->update(['PEstado' => 'Entregado']);
        $detalles->update(['FEntrega' => now()]);

        $objeto = Objetos::find($data['idObjeto']);
        $cantidadActual = $objeto->Cantidad;

        // Suma la cantidad devuelta a la cantidad actual
        $nuevaCantidad = $cantidadActual + $cantidadDevuelta;

        // Actualiza la cantidad de objetos y el estado con el nuevo valor y la abreviatura
        $objeto->update(['Cantidad' => $nuevaCantidad]);
        $objeto->update(['Estado' => $estadoAbreviado]);

        return response()->json(['success' => true, 'message' => 'Devolución exitosa']);
    }



    /**
     * Update the specified resource in storage.
     */
    public function actualizarEstadoDetalle()
    {
        $detalles = DetallesPrestamo::all();
        $FechaA = now();

        foreach ($detalles as $detalle) {
            $FRetorno = $detalle->FRetorno;
            $PEstado = $detalle->PEstado;

            if ($FechaA > $FRetorno && $PEstado === 'Pendiente') {
                $detalle->update(['PEstado' => "Vencido"]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function reportesPdf()
    {
        $prestamos = Prestamos::all();
        $detalles = DetallesPrestamo::all();

        // Obtener personas y objetos relacionados con los préstamos y detalles
        $personas = Personas::whereIn('id', $prestamos->pluck('idpersona'))->get();
        $objetos = Objetos::whereIn('id', $detalles->pluck('Id_objeto'))->get();

        // Crear un array asociativo con la información
        $reporte = compact('prestamos', 'detalles', 'personas', 'objetos');

        $pdf = Pdf::loadView('Prestamos.reportesPdf', compact('reporte'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

}
