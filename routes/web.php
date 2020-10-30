<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PiHomeController@home')->name('index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/activation/{code}','Api\RegisterApiController@activation')->name('user.activate');
Route::get('/manager/users','ManagerUserController@getAllUsers')->name('manager.users');
Route::get('/manager/companies', 'ManagerCompanyController@getInfoCompanies')->name('manager.companies');
Route::post('/manager/companies', 'ManagerCompanyController@updateInfoCompanies')->name('manager.update.companies');
Route::get('/manager/companies/changeName', 'ManagerCompanyController@getNameCompanyOld')->name('manager.getNameOld.companies');
Route::post('/manager/companies/changeName', 'ManagerCompanyController@updateNameCompany')->name('manager.updateName.companies');

Route::get('/user/invite/{token}', 'ManagerUserController@showInviteUserForm')->name('user.invite.request');
Route::post('/user/invite', 'ManagerUserController@inviteUser')->name('user.invite');
Route::post('/user/email', 'ManagerUserController@sendMailUser')->name('user.sendMail');
Route::post('/user/inactiveUser','ManagerUserController@inActiveUser')->name('user.inactive');
Route::post('/user/activeUser','ManagerUserController@ActiveUser')->name('user.active');
Route::get('/user/addRoleCompanyAdmin/{user_id}', 'ManagerUserController@addRoleCompanyAdmin')->name('companyAdmin.addRoleCompanyAdmin');
Route::get('/user/removeRoleCompanyAdmin/{user_id}', 'ManagerUserController@removeRoleCompanyAdmin')->name('companyAdmin.removeRoleCompanyAdmin');
Route::post('/user/deleteUser', 'ManagerUserController@deleteSoftUser')->name('companyAdmin.deleteSoftUser');
Route::get('/user/showDeleteUser', 'ManagerUserController@showDeleteSoftUser')->name('companyAdmin.showdeleteSoftUser');
Route::post('/home/updateUser', 'HomeController@updateInformationUser')->name('home.update.user');
Route::post('/home/changePassword', 'HomeController@changePassword')->name('home.update.password');
Route::post('/home/setCodeVerify', 'HomeController@setCodeVerify')->name('home.update.codeverify');
Route::post('/home/chanegEmail', 'HomeController@updateChangeEmail')->name('home.update.email');

Route::get('/company/list', 'SystemAdminController@getCompanies')->name('manage.companies');
Route::get('/company/department/list/{id}', 'SystemAdminController@getCompanyDepartments')->name('manage.company.departments');
Route::post('/company/department/create', 'SystemAdminController@createDepartment')->name('create.department');
Route::get('/user/addrole/{user_id}', 'SystemAdminController@addRoleCompanyAdmin')->name('company.user.addRoleCompanyAdmin');
Route::get('/user/removerole/{user_id}', 'SystemAdminController@removeRoleCompanyAdmin')->name('company.user.removeRoleCompanyAdmin');
Route::get('/tag/list', 'SystemAdminController@getTags')->name('manage.tags');
Route::get('/company/refresh/{company_number}', 'SystemAdminController@refreshCompanyInfo')->name('company.refresh');
Route::get('company/create', 'SystemAdminController@showCreateCompanyForm')->name('show.create.company.form');
Route::post('company/create', 'SystemAdminController@createCompany')->name('create.company');
Route::get('consultant/profilePage/{id}', 'SystemAdminController@showProfilePage')->name('show.profile.page');
Route::post('consultant/profilePage/{id}', 'SystemAdminController@updateProfilePage')->name('update.profile.page');