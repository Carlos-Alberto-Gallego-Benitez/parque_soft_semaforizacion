<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::get();
        return response()->json($empresas);
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

            $idUser=Auth::user()->id;

            $empresa=Empresa::create([
                'id_sector'=>$request->id_sector,
                'id_cantidad_trabajadores'=>$request->id_cantidad_trabajadores,
                'id_usuario'=>$idUser,
                'nombre'=>strtoupper($request->nombre_empresa),
                'nit'=>$request->nit,
                'direccion'=>strtoupper($request->direccion),
                'telefono'=>$request->telefono,
                'email'=>strtoupper($request->email),
                'representante'=>strtoupper($request->nombre_representante),
                'cc_representante'=>$request->cc,
            ]);

            DB::commit();

            return response()->json($empresa);

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

    public function showByIdUser($id)
    {
        $empresa = Empresa::where('id_usuario',$id)->first();
        return response()->json($empresa);
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

           $empresa=Empresa::find($request->id);
           $empresa->id_sector=$request->id_sector;
           $empresa->id_cantidad_trabajadores=$request->id_cantidad_trabajadores;
           $empresa->nombre=strtoupper($request->nombre_empresa);
           $empresa->nit=$request->nit;
           $empresa->direccion=strtoupper($request->direccion);
           $empresa->telefono=$request->telefono;
           $empresa->email=strtoupper($request->email);
           $empresa->representante=strtoupper($request->nombre_representante);
           $empresa->cc_representante=$request->cc;
           $empresa->save();

            DB::commit();

            return response()->json($empresa);

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
