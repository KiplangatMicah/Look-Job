<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Jobs\JobsController;
use App\Http\Controllers\Categories\categoriesController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\AdminController;

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/jobs/single{id}', [JobsController::class, 'single'])->name('single.job');

Route::post('/jobs/save', [JobsController::class, 'saveJob'])->name('save.job');

Route::post('/jobs/apply', [JobsController::class, 'applyJob'])->name('apply.job');

Route::get('/categories/single{name}', [categoriesController::class, 'singleCategory'])->name('category.single');
Route::get('/users/profile', [UsersController::class, 'profile'])->name('profile');
Route::get('/users/applications', [UsersController::class, 'applications'])->name('applications');

Route::get('/users/savedjobs', [UsersController::class, 'savedJobs'])->name('saved.jobs');
Route::get('/users/edit_details', [UsersController::class, 'editDetails'])->name('edit.details');

Route::post('/users/update_details', [UsersController::class, 'updateDetails'])->name('update.details');

Route::get('/users/edit_cv', [UsersController::class, 'editcv'])->name('edit.cv');

Route::post('/users/update_cv', [UsersController::class, 'updatecv'])->name('update.cv');

Route::any('search', [JobsController::class, 'search'])->name('search.job');


Route::get('admin/login', [AdminController::class, 'adminlogin'])->name('admin.login');
Route::post('admin/checklogin', [AdminController::class, 'checklogin'])->name('check.login');


Route::group(['prefix'=>'admin','middleware'=> 'auth:admin'],function(){

    Route::get('/', [AdminController::class, 'index'])->name('admins.dashboard');

});
Route::get('all-admins', [AdminController::class, 'admins'])->name('view.admins');
Route::get('createadmins', [AdminController::class, 'createadmins'])->name('create.admin');
Route::post('createadmins', [AdminController::class, 'storeadmins'])->name('store.admin');

Route::get('showcategories', [AdminController::class, 'showcategories'])->name('show.categories');

Route::get('createcates', [AdminController::class, 'createcategory'])->name('create.category');
Route::post('createcates', [AdminController::class, 'storecategory'])->name('store.category');

Route::get('editcates{id}', [AdminController::class, 'editcategory'])->name('edit.category');
Route::post('editcates{id}', [AdminController::class, 'updateCategory'])->name('update.category');

Route::get('deletecates{id}', [AdminController::class, 'deletecategory'])->name('delete.category');

Route::get('showJobs', [AdminController::class, 'allJobs'])->name('show.jobs');

Route::get('createjobs', [AdminController::class, 'createjobs'])->name('create.jobs');
Route::post('storejobs', [AdminController::class, 'storejobs'])->name('store.jobs');

Route::get('deletejobs{id}', [AdminController::class, 'deletejobs'])->name('delete.jobs');

Route::get('apps', [AdminController::class, 'apps'])->name('apps');

Route::get('postJob', [JobsController::class, 'postJob'])->name('post.job');
Route::post('postjobs', [JobsController::class, 'postjobs'])->name('post.jobs');

