<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use App\Models\DetallesPrestamo;
use App\Models\Objetos;
use App\Models\Personas;
use App\Models\Prestamos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class AlumnosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $alumnos =  Alumnos::select('alumnos.id', 'personas.nombre', 'personas.apellidos', 'alumnos.grado', 'alumnos.seccion')
            ->join('personas', 'alumnos.idpersona', '=', 'personas.id');
            return DataTables::of($alumnos)
                    ->addColumn('action', function($alumnos){
                        $editar = '<button class="btn btn-outline-warning btn-sm btn-editar-alumno " data-id="'.$alumnos->id.'" type="button"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-outline-danger btn-sm btn-eliminar-alumno " data-id="'.$alumnos->id.'" type="button"><i class="far fa-trash-alt"></i></button>';
                        return $editar;
                        
                    })
                    
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Alumnos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumnos $alumnos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar($id)
    {
        //
        $alumno = DB::select('CALL sp_llenarModalAlumnos(?)', [$id]);
        return response()->json($alumno);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $alumnos = Alumnos::find($id);
        $alumnos->grado = $request->input('gradoA');
        $alumnos->seccion = $request->input('seccionA');
        $alumnos->save();

        $personaid = $alumnos->idpersona;
        $obejeto = Personas::find($personaid);
        $obejeto->nombre = $request->input('nombreA');
        $obejeto->apellidos = $request->input('apellidosA');
        $obejeto->save();

        return response()->json(['success' => true, 'message' => 'Alumno actualizado correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $alumno = Alumnos::find($id);
        $persona = Personas::where('id', $alumno->idpersona)->first();
        $prestamo = Prestamos::where('idpersona', $persona->id)->first();
        $detalles = DetallesPrestamo::where('Id_prestamo', $prestamo->id)->get();
        $cantidadObjetosPendientes = $detalles->where('PEstado', 'Pendiente')->count();
        if($prestamo->EstadoP === 'Entregado'){
             $alumno->delete();
             $persona->delete();
             return response()->json(['success' => true, 'message' => 'Alumno eliminado correctamente.']);
        }
        if ($cantidadObjetosPendientes > 1) {
            return response()->json(['success' => false, 'message' => 'El alumno tiene ' . $cantidadObjetosPendientes . ' préstamos pendientes y no puede ser eliminado']);
        } elseif ($cantidadObjetosPendientes === 1) {
            return response()->json(['success' => false, 'message' => 'El alumno tiene ' . $cantidadObjetosPendientes . ' préstamo pendiente y no puede ser eliminado']);
        }
        // $detalles = DetallesPrestamo::where('Id_prestamo', $prestamo->id)->get();
        // foreach ($detalles as $detalle) {
        //     $cantidad = $detalle->cantidad;
        //     $idObjeto = $detalle->Id_objeto;
        //     $estadoPrestamo = $detalle->PEstado;
        //     if ($estadoPrestamo === 'Pendiente') {
        //         $objeto = Objetos::find($idObjeto);
        //         $objeto->Cantidad += $cantidad;
        //         $objeto->save();
        //     }
        // }
    
        // $alumno->delete();
        // if ($persona) {
        //     $persona->delete();
        // }
        return response()->json(['success' => true, 'message' => 'Alumno eliminado correctamente.']);
    }
}
