<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\Admin\LogFileController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\UserPanel\HomeController;
use App\Http\Controllers\Admin\TemplateController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

//clear cache route
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    echo '<script>alert("cache clear Success")</script>';
});
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    echo '<script>alert("config cache Success")</script>';
});
Route::get('/view', function () {
    Artisan::call('view:clear');
    echo '<script>alert("view clear Success")</script>';
});
Route::get('/route', function () {
    Artisan::call('route:cache');
    echo '<script>alert("route clear Success")</script>';
});
Route::get('/config-clear', function () {
    Artisan::call('config:clear');
    echo '<script>alert("config clear Success")</script>';
});
Route::get('/storage', function () {
    Artisan::call('storage:link');
    echo '<script>alert("linked")</script>';
});


// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('sitehome');
Route::get('updatepoststatus/{post}/{status}/{created_at}', [HomeController::class,'updatepoststatus'])->name('updatepoststatus');
Route::get('posts', [HomeController::class,'showpublicpost'])->name('showpublicpost');
Route::post('contactsubmit', [HomeController::class,'contactsubmit'])->name('contactsubmit');
Route::post('forgotpassword', [HomeController::class,'forgotpassword'])->name('forgotpassword');
Route::post('forgotPassuserotp', [HomeController::class,'forgotpassworduserotp'])->name('forgotPassuserotp');

// Guest Auth Routes
Route::group(['middleware' => ['preventBackHistory', 'guest']], function(){
    Route::get('/register', [HomeController::class, 'register'])->name('registeruser');
    Route::post('/register', [HomeController::class, 'registeruserform'])->name('registeruserform');
    Route::post('/resetuserform', [HomeController::class, 'resetuserform'])->name('resetuserform');
    Route::post('/registeruserotp', [HomeController::class, 'registeruserotp'])->name('registeruserotp');
    Route::post('/resendotp', [HomeController::class, 'resendotp'])->name('resendotp');
});

Route::get('dashredirect', [BaseController::class, 'dashRedirect'])->name('redirectafterlogin');

// User Auth Routes
Route::group(['middleware' => ['auth', 'preventBackHistory', 'userCheck']], function(){
    Route::post('myprofile', [HomeController::class, 'myprofileUpdate'])->name('myprofileUpdate');
    Route::post('passwordupdate', [HomeController::class, 'passwordupdate'])->name('passwordupdate');
    Route::get('addpost', [HomeController::class, 'viewaddmypost'])->name('addmypost');
    Route::post('addpost', [HomeController::class, 'addmypost'])->name('addmypost');
    Route::get('mypost', [HomeController::class, 'showmypost'])->name('showmypost');
    Route::get('changePostStatus/{id}', [HomeController::class, 'changePostStatus'])->name('changePostStatus');    
    Route::get('mydraft', [HomeController::class, 'showmypost'])->name('showmydraft');
    Route::post('mypostdelete', [HomeController::class, 'mypostdelete'])->name('mypostdelete');
    Route::get('editpost/{post}', [HomeController::class, 'editmypost'])->name('editmypost');
    Route::put('addpost/{post?}', [HomeController::class,'updatemypost'])->name('addmypost');
});


//Admin Without Auth Routes
Route::group(['prefix' => 'admin'], function() {
    Route::get('login', [AdminController::class, 'login'])->name('adminlogin');
});


// Admin - Subadmin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'preventBackHistory', 'adminCheck', 'verified']], function(){
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admindashboard');
    Route::get('change-status-user/{id}/{status}',[UserController::class, 'changeStatus'])->name('admin.users.changeStatus');
    Route::resource('users', UserController::class, ['as' => 'admin']);
    Route::get('change-status/{id}/{status}', [SubAdminController::class, 'changeStatus'])->name('admin.subadmin.changeStatus')->middleware('subadminCheck');
    Route::resource('subadmin', SubAdminController::class, ['as' => 'admin'])->middleware('subadminCheck');
    Route::get('template-change-status/{id}/{status}', [TemplateController::class, 'changeStatus'])->name('admin.template.changeStatus')->middleware('subadminCheck');
    Route::resource('template', TemplateController::class, ['as' => 'admin'])->middleware('subadminCheck');
    Route::get('delete/{logfiles}', [LogFileController::class, 'destroy'])->name('admin.logfiles.delete');
    Route::resource('logfiles', LogFileController::class, ['as' => 'admin']);
    Route::get('addFakePosts', [PostController::class, 'addFakePosts'])->name('admin.posts.addFakePosts');
    Route::post('postStatusUpdate', [PostController::class, 'postStatusUpdate'])->name('admin.posts.postStatusUpdate');
    Route::get('showpost/{post}', [PostController::class, 'showpost'])->name('admin.posts.showpost');
    Route::post('sendMessage', [PostController::class, 'sendMessage'])->name('admin.posts.sendMessage');
    Route::resource('posts', PostController::class, ['as' => 'admin']);
});


// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    \Illuminate\Support\Facades\Auth::user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth'])->name('verification.send');


Route::middleware(['auth:sanctum', 'verified'])->get('/companies', App\Http\Livewire\Companies::class)->name('companies');


//, 'middleware' => ['auth', 'admin']
// Old Useless Routes
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
