<?php

namespace App\Http\Controllers;

use App\Models\Secciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SeccionFormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $seccion = Secciones::create([
                'nombre' => strtoupper($request->nombre),
                'puntaje_maximo' => strtoupper($request->puntaje_maximo),
                'numero_preguntas' => strtoupper($request->numero_preguntas),
                'id_formulario'=>$request->id_formulario,
                'nivel_deseado'=>5
            ]);

            DB::commit();

            return response()->json($seccion);

        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage().PHP_EOL.$ex->getTraceAsString());
            return response()->json(['status' => 'fail', 'msg' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seccion=Secciones::where('id', $id)->first();
        return response()->json($seccion);
    }

    public function showByIdFormulario($id){
        $secciones= Secciones::with(['preguntas'])->
        where('id_formulario', $id)->get();

        return response()->json($secciones);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            DB::beginTransaction();

            $seccion=Secciones::find($request->id);
            $seccion->nombre=strtoupper($request->nombre);
            $seccion->puntaje_maximo=strtoupper($request->puntaje_maximo);
            $seccion->numero_preguntas=strtoupper($request->numero_preguntas);

            $seccion->save();

            DB::commit();

            return response()->json($seccion);

        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage().PHP_EOL.$ex->getTraceAsString());
            return response()->json(['status' => 'fail', 'msg' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seccion = Secciones::find($id);
        $seccion->delete();
    }

    public function estado($id)
    {
        $seccion = Secciones::find($id);

        if($seccion->activo=='S'){
            $seccion->update(['activo' => 'N']);
        }else{
            $seccion->update(['activo' => 'S']);
        }
    }
}
