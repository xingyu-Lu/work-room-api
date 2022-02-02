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
        Route::put('briefs/status', 'BriefsController@status')->name('briefs.status');
        Route::apiResource('briefs', 'BriefsController');

        // 领导团队
        Route::put('leaders/status', 'LeadersController@status')->name('leaders.status');
        Route::get('leaders/srclist', 'LeadersController@srclist')->name('leaders.srclist');
        Route::apiResource('leaders', 'LeadersController');

        // 医院文化
        Route::put('cultures/status', 'CulturesController@status')->name('cultures.status');
        Route::apiResource('cultures', 'CulturesController');

        // 历史沿革
        Route::put('historys/status', 'HistorysController@status')->name('historys.status');
        Route::apiResource('historys', 'HistorysController');

        // 历任院长
        Route::put('historyLeaders/status', 'HistoryLeadersController@status')->name('historyLeaders.status');
        Route::get('historyLeaders/srclist', 'HistoryLeadersController@srclist')->name('historyLeaders.srclist');
        Route::apiResource('historyLeaders', 'HistoryLeadersController');

        // 历任院长
        Route::put('historyPics/status', 'HistoryPicsController@status')->name('historyPics.status');
        Route::get('historyPics/srclist', 'HistoryPicsController@srclist')->name('historyPics.srclist');
        Route::apiResource('historyPics', 'HistoryPicsController');

        // 组织机构
        Route::put('organizations/status', 'OrganizationsController@status')->name('organizations.status');
        Route::apiResource('organizations', 'OrganizationsController');

        // 历任院长
        Route::put('news/status', 'NewsController@status')->name('news.status');
        Route::apiResource('news', 'NewsController');

        // 科室列表
        Route::put('technicalOffices/status', 'TechnicalOfficesController@status')->name('technicalOffices.status');
        Route::apiResource('technicalOffices', 'TechnicalOfficesController');        

        // 科室介绍
        Route::put('technicalOfficeIntroduces/status', 'TechnicalOfficeIntroduceController@status')->name('technicalOfficeIntroduces.status');
        Route::apiResource('technicalOfficeIntroduces', 'TechnicalOfficeIntroduceController');

        // 科室动态
        Route::put('technicalOfficeDynamics/status', 'TechnicalOfficeDynamicsController@status')->name('technicalOfficeDynamics.status');
        Route::apiResource('technicalOfficeDynamics', 'TechnicalOfficeDynamicsController'); 

        // 科室医生
        Route::put('technicalOfficeDoctors/status', 'TechnicalOfficeDoctorsController@status')->name('technicalOfficeDoctors.status');
        Route::apiResource('technicalOfficeDoctors', 'TechnicalOfficeDoctorsController');

        // 科室门诊
        Route::put('technicalOfficeOutpatients/status', 'TechnicalOfficeOutpatientsController@status')->name('technicalOfficeOutpatients.status');
        Route::apiResource('technicalOfficeOutpatients', 'TechnicalOfficeOutpatientsController');        

        // 科室特色医疗
        Route::put('technicalOfficeFeatures/status', 'TechnicalOfficeFeaturesController@status')->name('technicalOfficeFeatures.status');
        Route::apiResource('technicalOfficeFeatures', 'TechnicalOfficeFeaturesController');

        // 科室图片
        Route::put('technicalOfficePics/status', 'TechnicalOfficePicsController@status')->name('technicalOfficePics.status');
        Route::apiResource('technicalOfficePics', 'TechnicalOfficePicsController');

        // 科室健康科普
        Route::put('technicalOfficeHealthSciences/status', 'TechnicalOfficeHealthSciencesController@status')->name('technicalOfficeHealthSciences.status');
        Route::apiResource('technicalOfficeHealthSciences', 'TechnicalOfficeHealthSciencesController');

        // 专家介绍
        Route::put('experts/status', 'ExpertsController@status')->name('experts.status');
        Route::apiResource('experts', 'ExpertsController');

        // 科研动态
        Route::put('scientifics/status', 'ScientificsController@status')->name('scientifics.status');
        Route::apiResource('scientifics', 'ScientificsController');

        // 患者服务
        Route::put('patientServices/status', 'PatientServicesController@status')->name('patientServices.status');
        Route::apiResource('patientServices', 'PatientServicesController');

        // 党建
        Route::put('partys/status', 'PartysController@status')->name('partys.status');
        Route::apiResource('partys', 'PartysController');

        // 招聘
        Route::put('jobs/status', 'JobsController@status')->name('jobs.status');
        Route::apiResource('jobs', 'JobsController');

        // 员工之声
        Route::put('voiceEmployees/status', 'VoiceEmployeesController@status')->name('voiceEmployees.status');
        Route::apiResource('voiceEmployees', 'VoiceEmployeesController');

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
    Route::post('authorizations', 'AuthorizationsController@store')->name('login');
    
    // 轮播图
    Route::name('api.head.')->name('api.head.')->group(function () {
        Route::get('indexs', 'IndexsController@index')->name('indexs.index');
        // 注册
        Route::get('registers/code', 'RegistersController@code')->name('registers.code');
        Route::apiResource('registers', 'RegistersController');

        // 医院简介
        Route::get('briefs/yyjj', 'BriefsController@yyjj')->name('briefs.yyjj');
        // 领导团队
        Route::get('briefs/ldtd', 'BriefsController@ldtd')->name('briefs.ldtd');
        // 医院文化
        Route::get('briefs/yywh', 'BriefsController@yywh')->name('briefs.yywh');
        // 历史沿革
        Route::get('briefs/lsyg', 'BriefsController@lsyg')->name('briefs.lsyg');
        // 组织机构
        Route::get('briefs/zzjg', 'BriefsController@zzjg')->name('briefs.zzjg');

        // 医院新闻
        Route::get('news/yyxw', 'NewsController@yyxw')->name('news.yyxw');
        // 医院新闻详情
        Route::get('news/yyxw_detail', 'NewsController@yyxw_detail')->name('news.yyxw_detail');
    });

    // 需要 token 验证的接口
    // Route::middleware(['auth:api'])->name('api.head.')->group(function () {
    //     // 登录用户信息
    //     Route::get('admins/info', 'AdminsController@info')->name('admins.info');
    // });
});
