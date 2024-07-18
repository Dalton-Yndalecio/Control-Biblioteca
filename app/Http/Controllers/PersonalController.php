<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;
use App\Models\Personas;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $personal =  Personal::select('personales.id', 'personas.nombre', 'personas.apellidos', 'personales.Cargo', 'personales.Especialidad', 'personales.Condición')
            ->join('personas', 'personales.idpersona', '=', 'personas.id');
            return DataTables::of($personal)
                    ->addColumn('action', function($personal){
                        $editar = '<button class="btn btn-outline-warning btn-sm btn-editar-personal " data-id="'.$personal->id.'" type="button"><i class="fas fa-edit"></i></button>';
                        return $editar;
                        
                    })
                    
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Personal.index');
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
    public function show(Personal $personal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar($id)
    {
        
        $personal = DB::select('CALL sp_llenarModalPersonal(?)', [$id]);
        return response()->json($personal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $personal = Personal::find($id);
        $personal->Cargo = $request->input('cargoP');
        $personal->Especialidad = $request->input('especialidadP');
        $personal->Condición = $request->input('condicionP');
        $personal->save();

        $personaid = $personal->idpersona;
        $obejeto = Personas::find($personaid);
        $obejeto->nombre = $request->input('nombreP');
        $obejeto->apellidos = $request->input('apellidosP');
        $obejeto->save();

        return response()->json(['success' => true, 'message' => 'Personal actualizado correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personal $personal)
    {
        //
    }
}
