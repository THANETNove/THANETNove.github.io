<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StorageLocationController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\DurableArticlesController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\MaterialRequisitionController;
use App\Http\Controllers\DurableArticlesRequisitionController;
use App\Http\Controllers\DurableArticlesDamagedController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DurableArticlesRepairController;
use App\Http\Controllers\BetDistributionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//ใช้รวม
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('my-profile/{id}', [HomeController::class, 'myProfile'])->name('my-profile');
Route::get('new-password', [HomeController::class, 'newPassword'])->name('new-password');
Route::put('update-password/{id}', [HomeController::class, 'update'])->name('update-password');

Route::get('districts/{id}', [AddressController::class, 'districts'])->name('districts');
Route::get('subdistrict/{id}', [AddressController::class, 'subdistricts'])->name('subdistrict');

//ระบบเบิกวัสดุ
Route::get('material-requisition-index', [MaterialRequisitionController::class, 'index'])->name('material-requisition-index');
Route::post('material-requisition-index', [MaterialRequisitionController::class, 'index'])->name('material-requisition-index');
Route::get('material-requisition-create', [MaterialRequisitionController::class, 'create'])->name('material-requisition-create');
Route::get('get-material/{id}', [MaterialRequisitionController::class, 'groupMaterial'])->name('get-material');
Route::post('material-requisition-store', [MaterialRequisitionController::class, 'store'])->name('material-requisition-store');
Route::get('material-requisition-edit/{id}', [MaterialRequisitionController::class, 'edit'])->name('material-requisition-edit');
Route::put('material-requisition-update/{id}', [MaterialRequisitionController::class, 'update'])->name('material-requisition-update');
Route::get('material-requisition-destroy/{id}', [MaterialRequisitionController::class, 'destroy'])->name('material-requisition-destroy');
Route::get('material-requisition-export/pdf', [MaterialRequisitionController::class, 'exportPDF'])->name('material-requisition-export/pdf');

//ระบบเบิกครุภัณฑ์
Route::get('durable-articles-requisition-index', [DurableArticlesRequisitionController::class, 'index'])->name('durable-articles-requisition-index');
Route::post('durable-articles-requisition-index', [DurableArticlesRequisitionController::class, 'index'])->name('durable-articles-requisition-index');
Route::get('durable-articles-requisition-create', [DurableArticlesRequisitionController::class, 'create'])->name('durable-articles-requisition-create');
Route::post('durable-articles-requisition-store', [DurableArticlesRequisitionController::class, 'store'])->name('durable-articles-requisition-store');
Route::get('durable-articles-requisition-edit/{id}', [DurableArticlesRequisitionController::class, 'edit'])->name('durable-articles-requisition-edit');
Route::put('durable-articles-requisition-update/{id}', [DurableArticlesRequisitionController::class, 'update'])->name('durable-articles-requisition-update');
Route::get('durable-articles-requisition-destroy/{id}', [DurableArticlesRequisitionController::class, 'destroy'])->name('durable-articles-requisition-destroy');
Route::get('approval-update', [DurableArticlesRequisitionController::class, 'approvalUpdate'])->name('approval-update');
Route::get('approved/{id}', [DurableArticlesRequisitionController::class, 'approved'])->name('approved');
Route::post('not-approved', [DurableArticlesRequisitionController::class, 'notApproved'])->name('not-approved');
Route::get('durable-articles-requisition-show/{id}', [DurableArticlesRequisitionController::class, 'show'])->name('durable-articles-requisition-show');
Route::get('durable-articles-requisition-export/pdf', [DurableArticlesRequisitionController::class, 'exportPDF'])->name('durable-articles-requisition-export/pdf');
Route::get('get-articlesRes/{id}', [DurableArticlesRequisitionController::class, 'durableRequisition'])->name('get-articlesRes');


// is_drawer ผู้เบิก
/* Route::group(['middleware' => ['is_drawer']], function () {
Route::get('/storage-index', [StorageLocationController::class, 'index'])->name('storage-index');
Route::get('/storage-create', [StorageLocationController::class, 'create'])->name('storage-create');
Route::post('/storage-store', [StorageLocationController::class, 'store'])->name('storage-store');
}); */

// เจ้าหน้าที่วัสดุ หรือ หัวหน้าวัสดุ is_admin is_headAdmin
Route::group(['middleware' => ['is_admin']], function () {



    Route::get('storage-index', [StorageLocationController::class, 'index'])->name('storage-index');
    Route::post('storage-index', [StorageLocationController::class, 'index'])->name('storage-index');
    Route::get('storage-create', [StorageLocationController::class, 'create'])->name('storage-create');
    Route::post('storage-store', [StorageLocationController::class, 'store'])->name('storage-store');
    Route::get('storage-edit/{id}', [StorageLocationController::class, 'edit'])->name('storage-edit');
    Route::put('storage-update/{id}', [StorageLocationController::class, 'update'])->name('storage-update');
    Route::get('storage-destroy/{id}', [StorageLocationController::class, 'destroy'])->name('storage-destroy');
    Route::get('storage-update-status/{id}', [StorageLocationController::class, 'updateStatus'])->name('storage-update-status');
    Route::get('storage-export/pdf', [StorageLocationController::class, 'exportPDF'])->name('export/pdf');


    Route::get('personnel-index', [PersonnelController::class, 'index'])->name('personnel-index');
    Route::post('personnel-index', [PersonnelController::class, 'index'])->name('personnel-index');
    Route::get('personnel-create', [PersonnelController::class, 'create'])->name('personnel-create');
    Route::get('personnel-show/{id}', [PersonnelController::class, 'show'])->name('personnel-show');
    Route::get('personnel-edit/{id}', [PersonnelController::class, 'edit'])->name('personnel-edit');
    Route::post('personnel-store', [PersonnelController::class, 'store'])->name('personnel-store');
    Route::put('personnel-update/{id}', [PersonnelController::class, 'update'])->name('personnel-update');
    Route::get('personnel-destroy/{id}', [PersonnelController::class, 'destroy'])->name('personnel-destroy');
    Route::get('personnel-update-status/{id}', [PersonnelController::class, 'updateStatus'])->name('personnel-update-status');
    Route::get('personnel-export/pdf', [PersonnelController::class, 'exportPDF'])->name('personnel-export/pdf');

    Route::get('material-index', [MaterialController::class, 'index'])->name('material-index');
    Route::post('material-index', [MaterialController::class, 'index'])->name('material-index');
    Route::get('material-create', [MaterialController::class, 'create'])->name('material-create');
    Route::post('material-store', [MaterialController::class, 'store'])->name('material-store');
    Route::get('material-edit/{id}', [MaterialController::class, 'edit'])->name('material-edit');
    Route::put('material-update/{id}', [MaterialController::class, 'update'])->name('material-update');

    Route::get('durable-articles-index', [DurableArticlesController::class, 'index'])->name('durable-articles-index');
    Route::get('durable-articles-create', [DurableArticlesController::class, 'create'])->name('durable-articles-create');
    Route::post('durable-articles-store', [DurableArticlesController::class, 'store'])->name('durable-articles-store');
    Route::post('durable-articles-index', [DurableArticlesController::class, 'index'])->name('durable-articles-index');
    Route::get('durable-articles-edit/{id}', [DurableArticlesController::class, 'edit'])->name('durable-articles-edit');
    Route::put('durable-articles-update/{id}', [DurableArticlesController::class, 'update'])->name('durable-articles-update');

    Route::get('buy-index', [BuyController::class, 'index'])->name('buy-index');
    Route::post('buy-index', [BuyController::class, 'index'])->name('buy-index');
    Route::get('buy-create', [BuyController::class, 'create'])->name('buy-create');
    Route::post('buy-store', [BuyController::class, 'store'])->name('buy-store');
    Route::put('buy-update/{id}', [BuyController::class, 'update'])->name('buy-update');
    Route::get('buy-edit/{id}', [BuyController::class, 'edit'])->name('buy-edit');
    Route::get('buy-destroy/{id}', [BuyController::class, 'destroy'])->name('buy-destroy');
    Route::get('buy-status/{id}', [BuyController::class, 'statusBuy'])->name('buy-status');
    Route::get('buy-export/pdf', [BuyController::class, 'exportPDF'])->name('buy-export/pdf');
    Route::get('get-categories/{id}', [BuyController::class, 'categories'])->name('get-categories');
    Route::get('get-categoriesData/{id}', [BuyController::class, 'categoriesData'])->name('get-categoriesData');

    Route::get('department-index', [DepartmentController::class, 'index'])->name('department-index');
    Route::get('department-create', [DepartmentController::class, 'create'])->name('department-create');
    Route::post('department-store', [DepartmentController::class, 'store'])->name('department-store');
    Route::get('department-edit/{id}', [DepartmentController::class, 'edit'])->name('department-edit');
    Route::put('department-update/{id}', [DepartmentController::class, 'update'])->name('department-update');
    Route::get('department-destroy/{id}', [DepartmentController::class, 'destroy'])->name('department-destroy');


    Route::get('category-index', [CategoryController::class, 'index'])->name('category-index');
    Route::post('category-index', [CategoryController::class, 'index'])->name('category-index');
    Route::get('category-create', [CategoryController::class, 'create'])->name('category-create');
    Route::post('category-store', [CategoryController::class, 'store'])->name('category-store');
    Route::get('category-edit/{id}', [CategoryController::class, 'edit'])->name('category-edit');
    Route::put('category-update/{id}', [CategoryController::class, 'update'])->name('category-update');


    //ระบบครุภัณฑ์ชำรุด
    Route::get('durable-articles-damaged-index', [DurableArticlesDamagedController::class, 'index'])->name('durable-articles-damaged-index');
    Route::post('durable-articles-damaged-index', [DurableArticlesDamagedController::class, 'index'])->name('durable-articles-damaged-index');
    Route::get('durable-articles-damaged-create', [DurableArticlesDamagedController::class, 'create'])->name('durable-articles-damaged-create');
    Route::post('durable-articles-damaged-store', [DurableArticlesDamagedController::class, 'store'])->name('durable-articles-damaged-store');
    Route::get('durable-articles-damaged-edit/{id}', [DurableArticlesDamagedController::class, 'edit'])->name('durable-articles-damaged-edit');
    Route::put('durable-articles-damaged-update/{id}', [DurableArticlesDamagedController::class, 'update'])->name('durable-articles-damaged-update');
    Route::get('durable-articles-damaged-destroy/{id}', [DurableArticlesDamagedController::class, 'destroy'])->name('durable-articles-damaged-destroy');

    //ระบบการซ่อมครุภัณฑ์
    Route::get('durable-articles-repair-index', [DurableArticlesRepairController::class, 'index'])->name('durable-articles-repair-index');
    Route::post('durable-articles-repair-index', [DurableArticlesRepairController::class, 'index'])->name('durable-articles-repair-index');
    Route::get('durable-articles-repair-create', [DurableArticlesRepairController::class, 'create'])->name('durable-articles-repair-create');
    Route::post('durable-articles-repair-store', [DurableArticlesRepairController::class, 'store'])->name('durable-articles-repair-store');
    Route::get('get-articlesRepair/{id}', [DurableArticlesRepairController::class, 'articlesRepair'])->name('get-articlesRepair');
    Route::put('durable-articles-repair-update/{id}', [DurableArticlesRepairController::class, 'update'])->name('durable-articles-repair-update');
    Route::get('get-articlesRepair-edit/{id}', [DurableArticlesRepairController::class, 'edit'])->name('get-articlesRepair-edit');
    Route::get('get-articlesRepair-destroy/{id}', [DurableArticlesRepairController::class, 'destroy'])->name('get-articlesRepair-destroy');
    Route::get('get-articlesRepair-updateRepair/{id}', [DurableArticlesRepairController::class, 'updateRepair'])->name('get-articlesRepair-updateRepair');

    //ระบบแทงจำหน่ายครุภัณฑ์
    Route::get('bet-distribution-index', [BetDistributionController::class, 'index'])->name('bet-distribution-index');
    Route::get('bet-distribution-create', [BetDistributionController::class, 'create'])->name('bet-distribution-create');

});

//  หัวหน้าวัสดุ  is_headAdmin
/* Route::group(['middleware' => ['is_headAdmin']], function () {
Route::get('/storage-index', [StorageLocationController::class, 'index'])->name('storage-index');
Route::get('/storage-create', [StorageLocationController::class, 'create'])->name('storage-create');
Route::post('/storage-store', [StorageLocationController::class, 'store'])->name('storage-store');
}); */
