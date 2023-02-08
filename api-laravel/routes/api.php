<?php

use App\Http\Controllers\CantidadTrabajadoresController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EtapaController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\FormularioSectorEmpresaController;
use App\Http\Controllers\OpcionesRespuestaPreguntaController;
use App\Http\Controllers\OpcionRespuestaPreguntaSeccionController;
use App\Http\Controllers\PreguntasFormularioController;
use App\Http\Controllers\PreguntasSeccionesController;
use App\Http\Controllers\RespuestasUsuarioController;
use App\Http\Controllers\SeccionFormularioController;
use App\Http\Controllers\SectorEmpresaController;
use App\Http\Controllers\SFormularioSectorEmpresaController;
use App\Http\Controllers\SFormularioController;
use App\Http\Controllers\SRespuestasUsuarioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('sector-empresa')->group(function () {
    Route::get('/', [SectorEmpresaController::class, 'index']);
    Route::post('/store', [SectorEmpresaController::class, 'store']);
    Route::put('/update', [SectorEmpresaController::class, 'update']);
    Route::delete('/destroy', [SectorEmpresaController::class, 'destroy']);
    Route::get('/show/{id}', [SectorEmpresaController::class, 'show']);
});

Route::prefix('etapas')->group(function () {
    Route::get('/', [EtapaController::class, 'index']);
    Route::post('/store', [EtapaController::class, 'store']);
    Route::put('/update', [EtapaController::class, 'update']);
    Route::delete('/delete/{id}', [EtapaController::class, 'destroy']);
    Route::get('/show/{id}', [EtapaController::class, 'show']);
    Route::put('/estado/{id}', [EtapaController::class, 'estado']);
});

Route::prefix('cantidad-trabajadores')->group(function () {
    Route::get('/', [CantidadTrabajadoresController::class, 'index']);
    Route::post('/store', [CantidadTrabajadoresController::class, 'store']);
    Route::put('/update', [CantidadTrabajadoresController::class, 'update']);
    Route::delete('/destroy', [CantidadTrabajadoresController::class, 'destroy']);
    Route::get('/show/{id}', [CantidadTrabajadoresController::class, 'show']);
});

Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index']);
    Route::post('/store', [UsuarioController::class, 'store']);
    Route::put('/update', [UsuarioController::class, 'update']);
    Route::delete('/destroy', [UsuarioController::class, 'destroy']);
    Route::get('/show/{id}', [UsuarioController::class, 'show']);
});


Route::prefix('formularios')->group(function () {
    Route::get('/', [FormularioController::class, 'index']);
    Route::post('/store', [FormularioController::class, 'store']);
    Route::put('/update', [FormularioController::class, 'update']);
    Route::delete('/destroy', [FormularioController::class, 'destroy']);
    Route::get('/show/{id}', [FormularioController::class, 'show']);
});

Route::prefix('preguntas-formularios')->group(function () {
    Route::get('/', [PreguntasFormularioController::class, 'index']);
    Route::post('/store', [PreguntasFormularioController::class, 'store']);
    Route::put('/update', [PreguntasFormularioController::class, 'update']);
    Route::delete('/destroy', [PreguntasFormularioController::class, 'destroy']);
    Route::get('/show/{id}', [PreguntasFormularioController::class, 'show']);
    Route::get('/show-by-form/{id}', [PreguntasFormularioController::class, 'showByForm']);
});

Route::prefix('opciones-preguntas-formularios')->group(function () {
    Route::get('/', [OpcionesRespuestaPreguntaController::class, 'index']);
    Route::post('/store', [OpcionesRespuestaPreguntaController::class, 'store']);
    Route::put('/update', [OpcionesRespuestaPreguntaController::class, 'update']);
    Route::delete('/destroy', [OpcionesRespuestaPreguntaController::class, 'destroy']);
    Route::get('/show/{id}', [OpcionesRespuestaPreguntaController::class, 'show']);
    Route::get('/show-by-pre/{id}', [OpcionesRespuestaPreguntaController::class, 'showByPre']);
});

Route::prefix('formularios-sector')->group(function () {
    Route::get('/', [FormularioSectorEmpresaController::class, 'index']);
    Route::post('/store', [FormularioSectorEmpresaController::class, 'store']);
    Route::put('/update', [FormularioSectorEmpresaController::class, 'update']);
    Route::delete('/destroy', [FormularioSectorEmpresaController::class, 'destroy']);
    Route::get('/show/{id}', [FormularioSectorEmpresaController::class, 'show']);
    Route::get('/show-by-idFormulario/{id}', [FormularioSectorEmpresaController::class, 'showByIdFormulario']);
    Route::get('/show-by-idSector/{id}', [FormularioSectorEmpresaController::class, 'showByIdSector']);
});

Route::prefix('empresa')->group(function () {
    Route::get('/', [EmpresaController::class, 'index']);
    Route::post('/store', [EmpresaController::class, 'store']);
    Route::put('/update', [EmpresaController::class, 'update']);
    Route::delete('/destroy', [EmpresaController::class, 'destroy']);
    Route::get('/show/{id}', [EmpresaController::class, 'show']);
    Route::get('/show-by-idUSer/{id}', [EmpresaController::class, 'showByIdUser']);
});

Route::prefix('respuestas-usuario')->group(function () {
    Route::get('/', [RespuestasUsuarioController::class, 'index']);
    Route::post('/store', [RespuestasUsuarioController::class, 'store']);
    Route::put('/update', [RespuestasUsuarioController::class, 'update']);
    Route::delete('/destroy', [RespuestasUsuarioController::class, 'destroy']);
    Route::get('/show/{id}', [RespuestasUsuarioController::class, 'show']);
    Route::get('/show-by-idUser/{id}/{id_formulario}', [RespuestasUsuarioController::class, 'showByIdUser']);
    Route::get('/show-by-idForm/{id_formulario}', [RespuestasUsuarioController::class, 'showByIdForm']);
    Route::get('/show-by-idFormulario/{id}', [RespuestasUsuarioController::class, 'showByIdFormulario']);
});

//nuevas rutas
Route::prefix('configuracion-formularios')->group(function () {
    Route::get('/', [SFormularioController::class, 'index']);
    Route::post('/store', [SFormularioController::class, 'store']);
    Route::put('/update', [SFormularioController::class, 'update']);
    Route::delete('/destroy', [SFormularioController::class, 'destroy']);
    Route::get('/show/{id}', [SFormularioController::class, 'show']);
    Route::get('/showId/{id}', [SFormularioController::class, 'showId']);
});

Route::prefix('config-formularios-sector')->group(function () {
    Route::get('/', [SFormularioSectorEmpresaController::class, 'index']);
    Route::post('/store', [SFormularioSectorEmpresaController::class, 'store']);
    Route::put('/update', [SFormularioSectorEmpresaController::class, 'update']);
    Route::delete('/destroy', [SFormularioSectorEmpresaController::class, 'destroy']);
    Route::get('/show/{id}', [SFormularioSectorEmpresaController::class, 'show']);
    Route::get('/show-by-idFormulario/{id}', [SFormularioSectorEmpresaController::class, 'showByIdFormulario']);
    Route::get('/show-by-idSector/{id}', [SFormularioSectorEmpresaController::class, 'showByIdSector']);
});

Route::prefix('secciones-formulario')->group(function () {
    Route::get('/', [SeccionFormularioController::class, 'index']);
    Route::post('/store', [SeccionFormularioController::class, 'store']);
    Route::put('/update', [SeccionFormularioController::class, 'update']);
    Route::delete('/delete/{id}', [SeccionFormularioController::class, 'destroy']);
    Route::get('/show/{id}', [SeccionFormularioController::class, 'show']);
    Route::get('/show-by-idFormulario/{id}', [SeccionFormularioController::class, 'showByIdFormulario']);
    Route::put('/estado/{id}', [SeccionFormularioController::class, 'estado']);
});

Route::prefix('config-preguntas-formularios')->group(function () {
    Route::get('/', [PreguntasSeccionesController::class, 'index']);
    Route::post('/store', [PreguntasSeccionesController::class, 'store']);
    Route::put('/update', [PreguntasSeccionesController::class, 'update']);
    Route::delete('/destroy', [PreguntasSeccionesController::class, 'destroy']);
    Route::get('/show/{id}', [PreguntasSeccionesController::class, 'show']);
    Route::get('/show-by-form/{id}', [PreguntasSeccionesController::class, 'showByForm']);
    Route::get('/show-by-idSeccion/{id}', [PreguntasSeccionesController::class, 'showByIdSeccion']);
});

Route::prefix('config-opciones-preguntas-formularios')->group(function () {
    Route::get('/', [OpcionRespuestaPreguntaSeccionController::class, 'index']);
    Route::post('/store', [OpcionRespuestaPreguntaSeccionController::class, 'store']);
    Route::put('/update', [OpcionRespuestaPreguntaSeccionController::class, 'update']);
    Route::delete('/destroy', [OpcionRespuestaPreguntaSeccionController::class, 'destroy']);
    Route::get('/show/{id}', [OpcionRespuestaPreguntaSeccionController::class, 'show']);
    Route::get('/show-by-pre/{id}', [OpcionRespuestaPreguntaSeccionController::class, 'showByPre']);
});

Route::prefix('form-respuestas-usuario')->group(function () {
    Route::get('/', [SRespuestasUsuarioController::class, 'index']);
    Route::post('/store', [SRespuestasUsuarioController::class, 'store']);
    Route::put('/update', [SRespuestasUsuarioController::class, 'update']);
    Route::delete('/destroy', [SRespuestasUsuarioController::class, 'destroy']);
    Route::get('/show/{id}', [SRespuestasUsuarioController::class, 'show']);
    Route::get('/show-by-idUser/{id}/{id_formulario}', [SRespuestasUsuarioController::class, 'showByIdUser']);
    Route::get('/show-by-idForm/{id_formulario}', [SRespuestasUsuarioController::class, 'showByIdForm']);
    Route::get('/show-by-idFormulario/{id}', [SRespuestasUsuarioController::class, 'showByIdFormulario']);
});

