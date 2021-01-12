<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\My\ContactController;
use App\Http\Controllers\My\MyController;
use App\Http\Controllers\My\ToolController;
use App\Http\Controllers\PS\PersonController;
use App\Http\Controllers\PS\PSController;
use App\Http\Controllers\PS\EmployeeController;
use App\Http\Controllers\HomeController;

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
    return view('home.apps');
});

Auth::routes();

Route::get('/my/tools/password-edit', [ToolController::class, 'editPassword'])->name('my.tools.password-edit');
Route::patch('/my/tools/password', [ToolController::class, 'updatePassword'])->name('my.tools.password-update');
Route::get('/my/tools/email-edit', [ToolController::class, 'editEmail'])->name('my.tools.email-edit');
Route::patch('/my/tools/email', [ToolController::class, 'updateEmail'])->name('my.tools.email-update');
Route::get('/my/tools', [ToolController::class, 'index'])->name('my.tools');
Route::get('my/contact/edit', [ContactController::class, 'edit'])->name('my.contact.edit');
Route::patch('my/contact', [ContactController::class, 'update'])->name('my.contact.update');

Route::get('/my', [MyController::class, 'index'])->name('my');


Route::any('/ps/people/search', [PersonController::class, 'search'])->name('ps.people.search');
Route::get('/ps/people/create', [PersonController::class, 'create'])->name('ps.people.create');
Route::get('/ps/people/{person}/edit', [PersonController::class, 'edit'])->name('ps.people.edit');
Route::get('/ps/people/{person}/reset', [PersonController::class, 'reset'])->name('ps.people.reset');
Route::get('/ps/people/{person}/reset-done', [PersonController::class, 'resetdone'])->name('ps.people.resetdone');
Route::get('/ps/people/{person}/employ', [PersonController::class, 'employ'])->name('ps.people.employ');
Route::patch('/ps/people/{person}', [PersonController::class, 'update'])->name('ps.people.update');
Route::get('/ps/people/{person}', [PersonController::class, 'show'])->name('ps.people.show');
Route::post('/ps/people', [PersonController::class, 'store'])->name('ps.people.store');
Route::get('/ps/people', [PersonController::class, 'index'])->name('ps.people');

Route::any('/ps/employees/search', [EmployeeController::class, 'search'])->name('ps.employees.search');
Route::get('/ps/employees/{employee}', [EmployeeController::class, 'show'])->name('ps.employees.show');
Route::get('/ps/employees', [EmployeeController::class, 'index'])->name('ps.employees');

Route::get('/ps', [PSController::class, 'index'])->name('ps');


Route::get('/station/{station}/employees/{employee}', [EmployeeController::class, 'show'])->name('station.employees.show');
Route::get('/station/{station}/employees', [EmployeeController::class, 'index'])->name('station.employees');
Route::get('/station/{station}', [StationController::class, 'index'])->name('station');

Route::get('/help', [HomeController::class, 'help'])->name('help');
