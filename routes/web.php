<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\FrontPanel\LoginController;
use App\Http\Controllers\AccountPanel\ParserController;
use App\Http\Controllers\AccountPanel\AccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('storage-link', function () {
    exec(symlink('/home/goodgros/businessautomata.com/application/storage/app/public', '/home/goodgros/businessautomata.com/storage'));
    return response()->json('storage linked');
});



Route::get('clear/all', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return response()->json('all cache cleared');
});

Route::get('/', function () {
    return redirect('account/panel/login');
});

Route::get('account/panel/login', [LoginController::class, 'loadAccountLogin']);
Route::post('account/panel/login', [LoginController::class, 'authenticateAccountLogin']);

Route::group(['prefix' => 'account/panel', 'middleware' => 'allow.account.panel.access'], function () {
    Route::get('/parser', [ParserController::class, 'loadParser']);
    Route::post('/parser/parse', [ParserController::class, 'parse']);
    Route::get('/logout', [AccountController::class, 'logout']);
});
