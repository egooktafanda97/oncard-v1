<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Service\Control\ManagementCrud;
use Modules\V1\Providers\ManagementServiceProvider;


/*
|--------------------------------------------------------------------------
| API ROUTER GENERATE
*/

foreach (ManagementServiceProvider::RouterFormating() as $v_r) {
    foreach ($v_r as $key_s => $v_source) {
        Route::group([
            'middleware' => $v_source['middleware'],
            'prefix' => $v_source['prefix'],
        ], function ($router) use ($v_source) {
            foreach ($v_source['rute'] as $x => $y) {
                Route::{$y['method']}($y['rout'], [$y['class'], $y['function']]);
            }
        });
    }
}
/*
| END
|--------------------------------------------------------------------------
*/
// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'instansi',
// ], function ($router) {
//     Route::post('/store', function () {
//         dd(Management::RouterFormating());
//     });
//     // Route::get('/store', [\Modules\V1\Http\Controllers\V1Controller::class, 'testing']);
// });
