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

Route::middleware('auth:api')->get('/user', 'Api\UserApiController@getUserInfo');

Route::post('/registration', 'Api\RegisterApiController@registration');
Route::post('/users','Api\UserApiController@createUsers');
Route::post('/companies','Api\CompanyApiController@createCompany');

Route::get('/checkCompanyExists', 'Api\RegisterApiController@checkCompanyExists');
Route::get('/checkEmailExists', 'Api\RegisterApiController@checkEmailExists');
Route::get('/checkVerificationCode','Api\RegisterApiController@checkVerificationCodeExits');
Route::get('/company/getCompaniesData', 'Api\RegisterApiController@getCompaniesData');
Route::get('/company/updateIsVerified', 'SystemAdminController@updateIsVerifiedCompany');
Route::get('/user/updateIsVerified', 'SystemAdminController@updateIsVerifiedUser');
Route::get('/company/department/moveUsers', 'SystemAdminController@moveUsers');
Route::get('/company/department/inviteCompanyAdmin', 'SystemAdminController@inviteCompanyAdmin');
Route::get('/tag/update', 'SystemAdminController@updateTag')->name('update.tag');
Route::get('/tag/create', 'SystemAdminController@createTag')->name('create.tag');
Route::get('/tag/delete', 'SystemAdminController@deleteTag')->name('delete.tag');
Route::get('/company/updateCPVCode', 'SystemAdminController@updateCPVCode');
Route::get('/company/addConsultant', 'SystemAdminController@addConsultant');