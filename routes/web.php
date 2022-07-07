<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserBlogListController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// check if user then go user dashboard
Route::get('welcomeUser',function(){
    return redirect()->route('userBlogList');
})->middleware(['auth','user'])->name('user_dashboard');



// check if user then go admin dashboard

Route::get('/dashboard', function () {
    return redirect()->route('welcomeAdmin');
})->name('admin_dashboard');


// 
Route::group(['prefix'=>'admin','middleware'=>['admin','auth']],function()
{

    Route::get('welcomeAdmin',[AdminController::class,'welcomeAdmin'])->name('welcomeAdmin');
    Route::get('selectFile',[AdminController::class,'selectFile'])->name('selectFile');
    Route::post('storeCsvFile',[AdminController::class,'storeCsvFile'])->name('storeCsvFile');


    Route::get('lisDataOfCsvFile',[BlogController::class,'lisDataOfCsvFile'])->name('lisDataOfCsvFile');

    Route::get('getData',[BlogController::class,'getData'])->name('getData');

    Route::get('readCsvFile',[BlogController::class,'readCsvFile'])->name('readCsvFile');

    Route::get('deleteData/{id}',[BlogController::class,'deleteData'])->name('data.destroy');

    Route::get('editData/{id}',[BlogController::class,'editData'])->name('data.edit');

    Route::put('updateData/{id}',[BlogController::class,'updateData'])->name('update.data');

    Route::get('createData',[BlogController::class,'create'])->name('data.create');

    Route::post('storeData',[BlogController::class,'storeData'])->name('data.store');

    Route::post('post-sortable',[BlogController::class,'sortableDataUpdate'])->name('post-sortable');

    Route::post('update.status',[BlogController::class,'archiveBlog'])->name('update.status');

    Route::get('myDivSortable',[BlogController::class,'myDivSortable'])->name('myDivSortable');

  
});

Route::group(['prefix'=>'user','middleware'=>['user','auth']],function()
{
    Route::get('welcomeUser',[UserController::class,'welcomeUser'])->name('welcomeUser');

    Route::get('userBlogList',[UserBlogListController::class,'litOfBlog'])->name('userBlogList');
    Route::get('blogDetailPage/{id}',[UserBlogListController::class,'blogDetailPage'])->name('blogDetailPage');

    Route::post('postRating',[UserBlogListController::class,'postRating'])->name('post.rating');

});


require __DIR__.'/auth.php';



