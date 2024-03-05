<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ContractEquipmentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();


Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/phpinfo', function () {
    return phpinfo();
});

Route::get('/test/page', function () {
    dd(phpinfo());
});
Route::get('/test/home', function () {
    dd(phpinfo());
});


//employeee list
Route::get('/employeelist', 'App\Http\Controllers\HomeController@employeelist');
Route::put('/updateemployee/{id}', 'App\Http\Controllers\HomeController@updateemployee');
Route::put('/deleteemployee/{id}', 'App\Http\Controllers\HomeController@deleteemployee');

Route::put('/deleteequipment/{id}', 'App\Http\Controllers\HomeController@deleteequipment');
//insert different types for Maintenance Page
Route::get('/maintenance', 'App\Http\Controllers\HomeController@maintenance');
Route::put('insert', 'App\Http\Controllers\HomeController@insert');
Route::put('insert2', 'App\Http\Controllers\HomeController@insert2');
Route::put('insertfilter', 'App\Http\Controllers\HomeController@insertfilter');
Route::put('insertmanufacturers', 'App\Http\Controllers\HomeController@insertmanufacturers');
Route::put('insertlocation', 'App\Http\Controllers\HomeController@insertlocation');
Route::put('insertequiptype', 'App\Http\Controllers\HomeController@insertequiptype');
Route::put('updateprice', 'App\Http\Controllers\HomeController@updateprice');


//home page
Route::get('/', 'App\Http\Controllers\HomeController@main');
Route::get('/main', 'App\Http\Controllers\HomeController@main');

//equipment type for each contract (insert)
Route::put('insertfiltertype/{ContractID}', 'App\Http\Controllers\ContractEquipmentController@insertfiltertype');


//contract
Route::get('/contractlist', 'App\Http\Controllers\HomeController@tblcontracts');
Route::get('/viewcontract/{ContractID}', 'App\Http\Controllers\HomeController@viewcontract');
Route::post('/insertconImg/{ContractID}', 'App\Http\Controllers\HomeController@insertconImg');
Route::put('/updatecontract/{ContractID}', 'App\Http\Controllers\HomeController@updatecontract');

//Route::post('image-uploadcontracts/{$ContractID}', 'App\Http\Controllers\ImageController@contractimages');

//create contract
Route::get('/CreateContract', 'App\Http\Controllers\HomeController@CreateContract');
//Route::put('/insertcontractequipment2', 'App\Http\Controllers\HomeController@insertcontractequipment2');
Route::put('/insertcontract', 'App\Http\Controllers\HomeController@insertcontract');

//create contract base on existing contract 
Route::get('/createcontract2/{ContractID}', 'App\Http\Controllers\HomeController@createcontract2');
Route::put('/insertcontract2/{ContractID}', 'App\Http\Controllers\HomeController@insertcontract2');

//add notes and equipment to contract
Route::put('/insertcontractequipment/{ContractID}', 'App\Http\Controllers\HomeController@insertcontractequipment');
Route::put('/insertnotes/{ContractID}', 'App\Http\Controllers\HomeController@insertnotes');
Route::put('/insertnotesequipment/{EquipmentID}', 'App\Http\Controllers\HomeController@insertnotesequipment');
Route::put('/insertnotesbuilding/{BuildingID}', 'App\Http\Controllers\HomeController@insertnotesbuilding');

//equipment list page
Route::get('/equipmentlist', 'App\Http\Controllers\HomeController@tblequipment');

//equipment Page
Route::get('/viewequipment/{UnitID}', 'App\Http\Controllers\HomeController@viewequipment');
Route::put('/updateequipment/{equipmentID}', 'App\Http\Controllers\HomeController@updateequipment');

Route::post('/image-upload/{equipmentID}', 'App\Http\Controllers\imageController@equipImg');


//Building location 
Route::get('/viewlocation/{BuildingID}', 'App\Http\Controllers\HomeController@viewlocation');
Route::put('/updatelocation/{BuildingID}', 'App\Http\Controllers\HomeController@updatelocation');
Route::get('/Buildinglist', 'App\Http\Controllers\HomeController@Buildinglist');
Route::get('/createBuilding', 'App\Http\Controllers\HomeController@createBuilding');
Route::put('/insertbuilding', 'App\Http\Controllers\HomeController@insertbuilding');

//Profile Setting
Route::get('/Accountsetting', 'App\Http\Controllers\HomeController@Accountsetting');
Route::post('/updateAccount', 'App\Http\Controllers\HomeController@updateAccount');

//Reset password (imcomplete)
Route::get('change-password', 'App\Http\Controllers\ChangePasswordController@index');
Route::post('change-password', 'App\Http\Controllers\ChangePasswordController@store')->name('change.password');



//PDF 
Route::get('/generate_C_PDF/{contractID}', [PDFController::class, 'generate_C_PDF']);
Route::get('/RenewalSMP/{contractID}', [PDFController::class, 'RenewalSMP']);
Route::get('/BillMonthPDF', [PDFController::class, 'BillMonthPDF']);
Route::get('/EquipmentCheckPDF', [PDFController::class, 'EquipmentCheckPDF']);
Route::get('/RequestPricing/{contractID}', [PDFController::class, 'RequestPricing']);




Route::put('/deleteContractnote/{contractid}', 'App\Http\Controllers\HomeController@deleteContractnote');

Route::put('/deletecontract/{id}', 'App\Http\Controllers\HomeController@deletecontract');

Route::put('/deletemulticontract/{id}', 'App\Http\Controllers\HomeController@deletemulticontract');


Route::get('/CreateEquipment/{equipmentID}', 'App\Http\Controllers\HomeController@CreateEquipment');
Route::put('/insertequipment/{equipmentID}', 'App\Http\Controllers\HomeController@insertequipment');



Route::put('/deleteequipment/{id}', 'App\Http\Controllers\HomeController@deleteequipment');

Route::delete('/deleteequiptype', [HomeController::class, 'deleteFilter'])->name('delete.filter');

// change password in account setting 
Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');


//forget password
Route::get('forget-password', 'App\Http\Controllers\Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'App\Http\Controllers\Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post'); 
Route::get('reset-password/{token}', 'App\Http\Controllers\Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'App\Http\Controllers\Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');