<?php

namespace App\Http\Controllers;

use App\Models\OpcionesRespuestaPregunta;
use App\Models\PreguntasFormulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PreguntasFormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

            $pregunta = PreguntasFormulario::create([
                'id_formulario' => $request->id_formulario,
                'id_etapa' => $request->id_etapa,
                'nombre' => strtoupper($request->nombre),
                'tipo_pregunta' => $request->tipo,
            ]);

            if($request->opciones!=""){
                foreach ($request->opciones as $item) {
                    OpcionesRespuestaPregunta::create([
                        'id_pregunta' => $pregunta->id,
                        'opcion'=>strtoupper($item['opcion']),
                        'puntaje'=>$item['puntaje'],
                    ]);
                }
            }

            DB::commit();

            return response()->json($pregunta);

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

    public function showByForm($id)
    {
        $preguntas=PreguntasFormulario::where('id_formulario',$id)->with(['formulario','etapa','opciones'])->get();
        return response()->json($preguntas);
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

            $pregunta=PreguntasFormulario::find($request->id);
            $pregunta->id_etapa=$request->id_etapa;
            $pregunta->nombre=strtoupper($request->nombre);
            $pregunta->tipo_pregunta=$request->tipo;
            $pregunta->save();

            if($request->opciones!=""){

                $opcion_pregunta = OpcionesRespuestaPregunta::where('id_pregunta',$request->id)->get();

                foreach($opcion_pregunta as $item){
                    $item->delete();
                }
                foreach ($request->opciones as $item) {
                    OpcionesRespuestaPregunta::create([
                        'id_pregunta' => $pregunta->id,
                        'opcion'=>strtoupper($item['opcion']),
                        'puntaje'=>$item['puntaje'],
                    ]);
                }
            }

            DB::commit();

            return response()->json($pregunta);

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
        //
    }
}
