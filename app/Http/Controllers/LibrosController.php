<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Libros;
use App\Models\Objetos;
use App\Models\Estante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class LibrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $libros = Libros::with(['objeto'])->get();
            return DataTables::of($libros)
                    ->addColumn('action', function($libros){
                        $editar = '<button class="btn btn-outline-warning btn-sm btn-modal" data-modal="Editar" data-id="'.$libros->id.'" type="button"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-outline-danger btn-sm btn-delete-libro" data-id="' . $libros->id . '"><i class="far fa-trash-alt"></i></button>';
                        return $editar;
                        
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Libros.index');
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
        $obejeto->Nombre = $request->input('tituloL');
        $obejeto->Signatura = $request->input('signatura');
        $obejeto->Cantidad = $request->input('cantidad');
        $obejeto->Estado = $request->input('estado');
        $obejeto->save();
        $libros = new Libros();
        $libros->idobjeto = $obejeto->id;
        $libros->Autor = $request->input('autor');
        $libros->Editorial = $request->input('editorial');
        $libros->AñoEdicion = $request->input('añoEdicion');
        $libros->TipoLibro = $request->input('tipoLibro');
        $libros->Estante = $request->input('estante');
        $libros->Division = $request->input('division');
        $libros->save();
        return response()->json(['success' => true, 'message' => 'Libro  registrado correctamente.']);
        
    }

    /**
     * Display the specified resource.
     */
    public function registrarEstante(Request $request)
    {
        $estante = $request->input('codEstante');
        $existeEstante = Estante::where('CodEstante', $estante)->first();
        if($existeEstante){
            return response()->json(['success' => false, 'message' => 'Ya existe un estante similar']);
        }
        else{
            $estantes = new Estante();
            $estantes->CodEstante = $request->input('codEstante');
            $estantes->save();
            return response()->json(['success' => true, 'message' => 'Estante registrado correctamente.']);
        }
    }
    public function registrarDivision(Request $request)
    {
        $division = $request->input('CodDivision');
        $existeDivision = Division::where('CodDivision', $division)->first();
        if($existeDivision){
            return response()->json(['success' => false, 'message' => 'Ya existe una división similar']);
        }
        else{
            $divisiones = new Division();
            $divisiones->CodDivision = $request->input('CodDivision');
            $divisiones->save();
            return response()->json(['success' => true, 'message' => 'Division registrado correctamente.']);
        }
    }
    public function selectEstantes(){
        $estantes = Estante::all();
        return response()->json($estantes);
    }
    public function selectDivisiones(){
        $divsiones = Division::all();
        return response()->json($divsiones);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar($id)
    {
        //
        $libros = DB::select('CALL sp_llenarModalLibros(?)', [$id]);
        return response()->json($libros);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $libros = Libros::find($id);
        //$libros->idobjeto = $obejeto->id;
        $libros->Autor = $request->input('autor');
        $libros->Editorial = $request->input('editorial');
        $libros->AñoEdicion = $request->input('añoEdicion');
        $libros->TipoLibro = $request->input('tipoLibro');
        $libros->Estante = $request->input('estante');
        $libros->Division = $request->input('division');
        $libros->save();

        $objetoId = $libros->idobjeto;
        $obejeto = Objetos::find($objetoId);
        $obejeto->Nombre = $request->input('tituloL');
        $obejeto->Signatura = $request->input('signatura');
        $obejeto->Cantidad = $request->input('cantidad');
        $obejeto->Estado = $request->input('estado');
        $obejeto->save();

        return response()->json(['success' => true, 'message' => 'Libro actualizado correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $libro = Libros::find($id);
        $libro->delete();
        $objeto = Objetos::where('id', $libro->idobjeto)->first();
        if ($objeto) {
            $objeto->delete();
        }

        return response()->json(['success' => true, 'message' => 'Libro eliminado correctamente.']);
    }

}
