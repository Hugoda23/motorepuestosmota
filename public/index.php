<?php

/**
 * ---------------------------------------------------------------
 *  Laravel - Index público
 * ---------------------------------------------------------------
 *
 *  Este archivo es el punto de entrada principal de tu aplicación.
 *  En este caso está adaptado para Hostinger, donde el núcleo de
 *  Laravel está en /src y los archivos públicos (CSS, JS, imágenes)
 *  están en /public_html.
 *
 *  @autor: Hugo Díaz
 *  @proyecto: Motorepuestos Mota
 */

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Registrar el autoloader
|--------------------------------------------------------------------------
|
| Cargamos las clases generadas por Composer. 
| IMPORTANTE: ajustamos la ruta porque Laravel está dentro de /src.
|
*/

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';


/*
|--------------------------------------------------------------------------
| Ejecutar la solicitud
|--------------------------------------------------------------------------
|
| Procesa la solicitud entrante y devuelve la respuesta al navegador.
|
*/

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
