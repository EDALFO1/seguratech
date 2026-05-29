<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AuthController,
    EmpresaLaboralController,
    AfiliadoController,
    AfiliacionController,
    ReciboController,
    ReciboDetalleController,
    RemisionController,
    ExportBatchController,
    EpsController,
    ArlController,
    PensionController,
    CajaController,
    AsesorController,
    ServicioController,
    EmpresaExternaController,
    IncapacidadController,
    NotaController,
    UserController,
    DocumentoController,
    EmpresaController,
    RolController,
    SubtipoCotizanteController,
    ParametroAnualController,
    AfiliadoServicioController,
    RemisionDetalleController
};

/*
|--------------------------------------------------------------------------
| RUTAS PUBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('dashboard'));

Route::view('/login', 'modules.auth.login')->name('login');

Route::post('/logear', [AuthController::class, 'logear'])->name('logear');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |-----------------------------------
    | GENERALES
    |-----------------------------------
    */

    Route::view('/dashboard', 'modules.dashboard.home')->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('seleccionar-empresa', [AuthController::class, 'seleccionarEmpresa'])
        ->name('seleccionar.empresa');

    Route::post('cambiar-empresa', [AuthController::class, 'cambiarEmpresa'])
        ->name('cambiar.empresa');

    Route::post('/afiliados/importar', [AfiliadoController::class, 'importar'])
        ->name('afiliados.importar');

    Route::get('/afiliados/plantilla', [AfiliadoController::class, 'descargarPlantilla'])
        ->name('afiliados.plantilla');


    /*
    |-----------------------------------
    | USUARIOS
    |-----------------------------------
    */

    Route::resource('usuarios', UserController::class);


    /*
    |-----------------------------------
    | EMPRESAS
    |-----------------------------------
    */

    Route::resource('empresas', EmpresaController::class)
        ->parameters(['empresas' => 'empresa']);

    Route::resource('empresas_laborales', EmpresaLaboralController::class)
        ->parameters(['empresas_laborales' => 'empresa_laboral']);

    Route::resource('empresas_externas', EmpresaExternaController::class);


    /*
    |-----------------------------------
    | AFILIADOS
    |-----------------------------------
    */

    // 🔥 RUTAS ESPECÍFICAS PRIMERO
    Route::get('/afiliados/buscar', [AfiliadoController::class, 'buscar'])
        ->name('afiliados.buscar');

    Route::get('afiliado-servicio/{id}', [RemisionController::class, 'valorServicio']);

    // 🔥 RESOURCE
    Route::resource('afiliados', AfiliadoController::class)
        ->parameters(['afiliados' => 'afiliado']);

    Route::resource('afiliaciones', AfiliacionController::class)
        ->parameters(['afiliaciones' => 'afiliacion']);

    Route::resource('afiliado_servicios', AfiliadoServicioController::class)
        ->parameters(['afiliado_servicios' => 'afiliado_servicio']);


    /*
    |-----------------------------------
    | RECIBOS
    |-----------------------------------
    */

    Route::prefix('recibos')->name('recibos.')->group(function () {

        Route::post('preview', [ReciboController::class, 'preview'])->name('preview');

        Route::post('generar', [ReciboController::class, 'generar'])->name('generar');

        Route::get('activos-siguiente', [ReciboController::class, 'activosSiguientePeriodo'])
            ->name('activos');

        Route::get('sin-recibo', [ReciboController::class, 'usuariosSinRecibo'])
            ->name('sin_recibo');

        Route::post('cerrar-periodo', [ReciboController::class, 'cerrarPeriodo'])
            ->name('cerrar_periodo');

        Route::post('generar/{afiliado}', [ReciboController::class, 'generarUno'])
            ->name('generar.uno');

        Route::post('generar-todos', [ReciboController::class, 'generarTodos'])
            ->name('generar.todos');

        Route::get('exportar-vigentes', [ReciboController::class, 'exportarVigentes'])
            ->name('exportar.vigentes');
    });

    Route::resource('recibos', ReciboController::class);
    Route::resource('recibo_detalles', ReciboDetalleController::class);


    /*
    |-----------------------------------
    | REMISIONES
    |-----------------------------------
    */

    Route::resource('remisiones', RemisionController::class);

    Route::get('/buscar-afiliados', [RemisionController::class, 'buscarAfiliados'])
        ->name('buscar.afiliados');

    Route::get('calcular-dias/{afiliado}/{fecha}', [RemisionController::class, 'calcularDias']);

    Route::post('remisiones/preview', [RemisionController::class, 'preview'])
        ->name('remisiones.preview');

    Route::get('remisiones/{id}/imprimir', [RemisionController::class, 'imprimir'])
        ->name('remisiones.imprimir');

    Route::resource('remision_detalles', RemisionDetalleController::class);


    /*
    |-----------------------------------
    | EXPORTACIONES
    |-----------------------------------
    */

    Route::prefix('exportaciones')->name('export.')->group(function () {

    Route::get('/', [ExportBatchController::class, 'index'])->name('index');

    Route::post('/crear', [ExportBatchController::class, 'crearLote'])->name('crear');

    // ✅ PRIMERO rutas específicas
    Route::get('pila-excel', [ReciboController::class, 'exportarPilaExcel'])
        ->name('pila.excel');

    Route::get('afiliados/exportar', [AfiliadoController::class, 'exportar'])
        ->name('afiliados.exportar');

    // ❗ DESPUÉS las dinámicas
    Route::get('{id}', [ExportBatchController::class, 'show'])->name('show');

    Route::post('{id}/reversar', [ExportBatchController::class, 'reversar'])
        ->name('reversar');

    Route::get('{id}/descargar', [ExportBatchController::class, 'descargar'])
        ->name('descargar');
});


    /*
    |-----------------------------------
    | PARAMETROS
    |-----------------------------------
    */

    Route::resources([
        'eps' => EpsController::class,
        'arls' => ArlController::class,
        'pensions' => PensionController::class,
        'cajas' => CajaController::class,
        'documentos' => DocumentoController::class,
        'subtipo_cotizantes' => SubtipoCotizanteController::class,
        'roles' => RolController::class,
        'asesores' => AsesorController::class,
        'servicios' => ServicioController::class,
        'incapacidades' => IncapacidadController::class,
        'notas' => NotaController::class,
    ]);

    Route::resource('parametros_anuales', ParametroAnualController::class)
        ->parameters([
            'parametros_anuales' => 'parametro_anual'
        ]);

});