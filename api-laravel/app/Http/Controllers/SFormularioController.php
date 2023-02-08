<?php

namespace App\Http\Controllers;

use App\Models\SFormulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SFormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formularios=SFormulario::with(['formulario_sector.sector'])->get();
        return response()->json($formularios);
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

            $id_usuario=Auth::user()->id;

            $formulario = SFormulario::create([
                'nombre' => strtoupper($request->nombre),
                'id_usuario'=>$id_usuario,
            ]);

            DB::commit();

            return response()->json($formulario);

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
        $formulario=SFormulario::where('id', $id)->first();
        return response()->json($formulario);
    }

    public function showId($id)
    {
        $formulario=SFormulario::where('id', $id)
        ->with(['secciones.preguntas.opciones'])->first();
        return response()->json($formulario);
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

            $formulario=SFormulario::find($request->id);
            $formulario->nombre=strtoupper($request->nombre);
            $formulario->save();

            DB::commit();

            return response()->json($formulario);

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
