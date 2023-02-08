<?php

namespace App\Http\Controllers;

use App\Models\FormularioSectorEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormularioSectorEmpresaController extends Controller
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

            $formulario=FormularioSectorEmpresa::create([
                'id_formulario'=>$request->id_formulario,
                'id_sector'=>$request->id_sector
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
        //
    }

    public function showByIdFormulario($id)
    {
        $formulario_sector=FormularioSectorEmpresa::where('id_formulario',$id)->
        with('sector')->get();

        return response()->json($formulario_sector);
    }

    public function showByIdSector($id)
    {
        $formulario_sector=FormularioSectorEmpresa::where('id_sector',$id)->
        with('formulario')->get();

        return response()->json($formulario_sector);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
