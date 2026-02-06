<?php

use Illuminate\Support\Facades\Route;
// use Lagdo\DbAdmin\Db\DbAdminPackage;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    // Jaxon DbAdmin routes
    Route::get('/dbadmin', fn() => view('dbadmin'))
        ->middleware(['jaxon.dbadmin.config'])
        ->name('dbadmin');
    Route::post('/dbadmin/jaxon', fn() => response()->json([]))
        ->middleware(['jaxon.dbadmin.config', 'jaxon.ajax'])
        ->name('dbadmin.jaxon');
    // Route::get('/export/{filename}', function(string $filename) {
    //     $reader = jaxon()->package(DbAdminPackage::class)->getOption('export.reader');
    //     $content = !is_callable($reader) ? "No export reader set." : $reader($filename);
    //     return response($content)->header('Content-Type', 'text/plain');
    // })->middleware(['auth', 'jaxon.dbadmin.config'])
    //     ->name('export');
    Route::get('/dbaudit', fn() => view('dbaudit'))
        ->middleware(['jaxon.dbaudit.config'])
        ->name('dbaudit');
    Route::post('/dbaudit/jaxon', fn() => response()->json([]))
        ->middleware(['jaxon.dbaudit.config', 'jaxon.ajax'])
        ->name('dbaudit.jaxon');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
