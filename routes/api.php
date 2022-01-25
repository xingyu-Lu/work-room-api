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

        // 管理员
        Route::put('admins/changepwd', 'AdminsController@changepwd')->name('admins.changepwd');
        Route::put('admins/status', 'AdminsController@status')->name('admins.status');
        Route::apiResource('admins', 'AdminsController');

        // 菜单
        Route::put('menus/status', 'MenusController@status')->name('menus.status');
        Route::get('menus/list', 'MenusController@list')->name('menus.list');
        Route::apiResource('menus', 'MenusController');

        // 轮播图
        Route::put('rotates/status', 'RotatesController@status')->name('rotates.status');
        Route::get('rotates/srclist', 'RotatesController@srclist')->name('rotates.srclist');
        Route::apiResource('rotates', 'RotatesController');

        // 医院简介
        Route::apiResource('briefs', 'BriefsController');        

        //文件下载
        Route::get('files/down', 'FilesController@down')->name('files.down');
        //文件上传
        Route::post('files/upload', 'FilesController@upload')->name('files.upload');
        //文件上传(多)
        Route::post('files/uploads', 'FilesController@uploads')->name('files.uploads');

    });
});


Route::namespace('Api\Head')->prefix('head')->group(function () {
    // 获取 token
    // Route::post('authorizations', 'AuthorizationsController@store')->name('login');
    
    // 轮播图
    Route::name('api.head.')->name('api.head.')->group(function () {
        Route::get('rotates', 'RotatesController@index')->name('rotates.index');
    });

    // 需要 token 验证的接口
    Route::middleware(['auth:api'])->name('api.head.')->group(function () {
        // 登录用户信息
        Route::get('admins/info', 'AdminsController@info')->name('admins.info');
    });
});
