<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Homepage;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Back\Dashboard;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\AdminBlogController;
use App\Http\Controllers\Back\AdminCategoryController;




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

/*BackEnd Route*/
Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function () {

    Route::get('login', [AuthController::class, 'login'])->name('login');

    Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');

});

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function () {

    Route::get('panel',[Dashboard::class,'getPanel'])->name('dashboard'); // Bunu yukarıya aldık çünkü aşşapğıda olduğu zaman diğer
    // routerların parametre beklemesinden dolayı bunun url adresindekileride
    // parametre olarak alıp kategori tablosunda arıyor bulamadığı içinde 403 dönüyor.

    /*-------Blog Routes-------*/

    Route::get('blogs/wasDeleted/',[AdminBlogController::class, 'trashed'])->name('deleted.blog');

    Route::resource('blogs',AdminBlogController::class);

    Route::get('image/{id}',[AdminBlogController::class,'showImage'])->name('showImage');

    Route::get('/switch', [AdminBlogController::class,'switch'])->name('switch');

    Route::get('/softdeleteBlog/{id}', [AdminBlogController::class,'softDelete'])->name('soft.delete.blog');

    Route::get('blogs/recover/{id}',[AdminBlogController::class, 'recover'])->name('recover.blog');

    Route::get('/harddeleteBlog/{id}', [AdminBlogController::class,'hardDelete'])->name('hard.delete.blog');

    //Route::post('admin/register',[AuthController::class,''])->name('admin.register.post');


    /*-------Category Routes-------*/

    Route::get('category', [AdminCategoryController::class, 'index'])->name('category');

    Route::get('category/switch',[AdminCategoryController::class,'switch'])->name('category.switch');

    Route::post('category/create',[AdminCategoryController::class,'create'])->name('category.create');

    Route::get('category/edit',[AdminCategoryController::class,'edit'])->name('category.edit');

    Route::post('category/update',[AdminCategoryController::class,'update'])->name('category.update');

    Route::post('category/delete',[AdminCategoryController::class, 'delete'])->name('category.delete');

    Route::get('logout',[AuthController::class,'logout'])->name('logout');
    //Route::post('admin/register',[AuthController::class,''])->name('admin.register.post');

});



/*FrontEnd Route*/


Route::get('/',[Homepage::class,'index'])->name('fronthomepage'); // Anasayfa routerı

Route::get('sayfa',[Homepage::class,'index']); //Pagination sayfaralı için

Route::get('/categories',[CategoryController::class,'index'])->name('categorypage'); //categrorilerin listelendiği router

Route::get('/category/{category}',[CategoryController::class,'catDetail'])->name('categorypagedetail');// burada categorilerin detayı yani hangi yazıya sahip olduklarını getiren sayfa

Route::get('/{category}/{slug}',[BlogController::class,'blogSingle'])->name('frontdetailpage'); // Blog sayfası routerı

Route::get('/{sayfa}',[Homepage::class,'page'])->name('page');





