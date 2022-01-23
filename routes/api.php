<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('Api\Back')->prefix('back')->group(function () {
    // 获取 token
    Route::post('authorizations', 'AuthorizationsController@store')->name('login');

    // 需要 token 验证的接口
    Route::middleware(['auth:api'])->name('api.back.')->group(function () {
        Route::apiResource('contracttypes', 'ContractTypeController'); //合同类型
        Route::apiResource('contracts', 'ContractController'); //合同
        Route::apiResource('supplier-bank-accounts', 'SupplierBankAccountController'); //银行

        // 登录用户信息
        Route::get('admins/info', 'AdminsController@info')->name('admins.info');

        // 菜单
        Route::apiResource('menus', 'MenusController');
    });
});
