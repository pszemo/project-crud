<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Mail\MailableProject;
use Illuminate\Support\Facades\Mail;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

});

require __DIR__.'/auth.php';


Route::get('/project/edit/{id}', [ProjectController::class,'edit'])->name('project.edit');
Route::get('/project/create', [ProjectController::class,'create'])->name('project.create');
Route::post('/project/save', [ProjectController::class, 'store'])->name('project.store');
Route::post('/project/update', [ProjectController::class, 'update'])->name('project.update');
Route::get('/project/delete/{id}',[ProjectController::class,'destroy'])->name('project.delete');
Route::post('/project/send',[ProjectController::class,'send'])->name('project.send');
Route::get('/project/list', [ProjectController::class,'index'])->name('project.list');
Route::get('/project/filter', [ProjectController::class,'filter'])->name('project.filter');
