<?php

namespace App\Http\Controllers;

use App\Models\Moviliarios;
use App\Models\Objetos;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class MoviliarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if($request->ajax()){
            $moviliarios=  Moviliarios::with(['objeto'])->get();
            return DataTables::of($moviliarios)
                    ->addColumn('action', function($moviliarios){
                        $editar = '<button class="btn btn-outline-warning btn-sm btn-modal" data-modal="Editar" data-id="'.$moviliarios->id.'" type="button"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-outline-danger btn-sm btn-delete-moviliario" data-id="' . $moviliarios->id . '"><i class="far fa-trash-alt"></i></button>';
                        return $editar;
                        
                    })
                    
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('moviliaria.index');
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
        $obejeto = new Objetos();
        $obejeto->Nombre = $request->input('nombre');
        $obejeto->Signatura = $request->input('signatura');
        $obejeto->Cantidad = $request->input('cantidad');
        $obejeto->Estado = $request->input('estado');
        $obejeto->save();
        $moviliarios = new Moviliarios();
        $moviliarios->idobjeto = $obejeto->id;
        $moviliarios->Observacion = $request->input('observacion');
        $moviliarios->save();
        return response()->json(['success' => true, 'message' => 'Moviliario  registrado correctamente.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Moviliarios $moviliarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar($id)
    {
        //
        $moviliario = DB::select('CALL sp_llenarModaMoviliario(?)', [$id]);
        
        return response()->json($moviliario);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $moviliario = Moviliarios::find($id);
        $moviliario->Observacion = $request->input('observacion');
        $moviliario->save();

        $Objetoid = $moviliario->idobjeto;
        $obejeto = Objetos::where('id', $Objetoid)->first();

        $obejeto->Nombre = $request->input('nombre');
        $obejeto->Signatura = $request->input('signatura');
        $obejeto->Cantidad = $request->input('cantidad');
        $obejeto->Estado = $request->input('estado');
        $obejeto->save();

        return response()->json(['success' => true, 'message' => 'Libro actualizado correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $moviliario = Moviliarios::find($id);
        $moviliario->delete();

        $objeto = Objetos::where('id', $moviliario->idobjeto)->first();
        if ($objeto) {
            $objeto->delete();
        }

        return response()->json(['success' => true, 'message' => 'Mobiliario eliminado correctamente.']);
    }
}
