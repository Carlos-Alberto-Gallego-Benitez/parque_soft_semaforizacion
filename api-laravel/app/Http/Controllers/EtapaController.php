<?php

namespace App\Http\Controllers;

use App\Models\Etapa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EtapaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Etapa::with([
            'preguntas' => function($query) use ($request){
                $query->when($request->has('id_formulario'), function($query) use ($request){
                    $query->where('id_formulario', $request->id_formulario);
                })
                ->with(['formulario','opciones']);
            }])
            ->get();
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

            $etapa = Etapa::create([
                'nombre' => strtoupper($request->nombre),
                'puntaje_maximo' => strtoupper($request->puntaje_maximo),
                'numero_preguntas' => strtoupper($request->numero_preguntas),
            ]);

            DB::commit();

            return response()->json($etapa);

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
        //
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

            $etapa=Etapa::find($request->id);
            $etapa->nombre=strtoupper($request->nombre);
            $etapa->puntaje_maximo=strtoupper($request->puntaje_maximo);
            $etapa->numero_preguntas=strtoupper($request->numero_preguntas);

            $etapa->save();

            DB::commit();

            return response()->json($etapa);

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
        $etapa = Etapa::find($id);
        $etapa->delete();
    }

    public function estado($id)
    {
        $etapa = Etapa::find($id);

        if($etapa->activo=='S'){
            $etapa->update(['activo' => 'N']);
        }else{
            $etapa->update(['activo' => 'S']);
        }
    }
}
