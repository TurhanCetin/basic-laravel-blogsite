<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Homepage;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Back\Dashboard;


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

Route::get('/',[Homepage::class,'index'])->name('fronthomepage'); // Anasayfa routerı

Route::get('sayfa',[Homepage::class,'index']); //Pagination sayfaralı için

Route::get('/{category}/{slug}',[BlogController::class,'blogSingle'])->name('frontdetailpage'); // Blog sayfası routerı

Route::get('/categories',[CategoryController::class,'index'])->name('categorypage'); //categrorilerin listelendiği router

Route::get('/{slug}',[CategoryController::class,'catDetail'])->name('categorypagedetail');// burada categorilerde hangi yazıların bulunduğu routerı

Route::get('/{sayfa}',[Homepage::class,'page'])->name('page');


//BackEnd Route

Route::get('admin/panel',[Dashboard::class,'getPanel'])->name('admin.dashboard');


