<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\My\ContactController;
use App\Http\Controllers\My\MyController;
use App\Http\Controllers\My\ToolController;

use App\Http\Controllers\PS\PSController;
use App\Http\Controllers\PS\PersonController;
use App\Http\Controllers\PS\ItemController;
use App\Http\Controllers\PS\EmployeeController;
use App\Http\Controllers\PS\UserController;

use App\Http\Controllers\RS\RSController;

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
Route::get('/ps/people/{person}/reset-done', [PersonController::class, 'resetdone'])->name('ps.people.reset-done');
Route::get('/ps/people/{person}/employ', [PersonController::class, 'employ'])->name('ps.people.employ');
Route::post('/ps/people/{person}/employ-done', [PersonController::class, 'employdone'])->name('ps.people.employ-done');
Route::patch('/ps/people/{person}', [PersonController::class, 'update'])->name('ps.people.update');
Route::get('/ps/people/{person}', [PersonController::class, 'show'])->name('ps.people.show');
Route::post('/ps/people', [PersonController::class, 'store'])->name('ps.people.store');
Route::get('/ps/people', [PersonController::class, 'index'])->name('ps.people');

Route::any('/ps/employees/search', [EmployeeController::class, 'search'])->name('ps.employees.search');
Route::get('/ps/employees/active', [EmployeeController::class, 'displayActive'])->name('ps.employees.active');
Route::get('/ps/employees/unassigned', [EmployeeController::class, 'displayUnassigned'])->name('ps.employees.unassigned');
Route::get('/ps/employees/terminated', [EmployeeController::class, 'displayTerminated'])->name('ps.employees.terminated');
Route::get('/ps/employees/{employee}/confirm-delete', [EmployeeController::class, 'confirmDelete'])->name('ps.employees.confirm-delete');
Route::delete('/ps/employees/{employee}', [EmployeeController::class, 'delete'])->name('ps.employees.delete');
Route::get('/ps/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('ps.employees.edit');
Route::get('/ps/employees/{employee}/si', [EmployeeController::class, 'si'])->name('ps.employees.si');
Route::patch('/ps/employees/{employee}/si-done', [EmployeeController::class, 'sidone'])->name('ps.employees.si-done');
Route::get('/ps/employees/{employee}/pr', [EmployeeController::class, 'pr'])->name('ps.employees.pr');
Route::patch('/ps/employees/{employee}/pr-done', [EmployeeController::class, 'prdone'])->name('ps.employees.pr-done');
Route::get('/ps/employees/{employee}/ee', [EmployeeController::class, 'ee'])->name('ps.employees.ee');
Route::patch('/ps/employees/{employee}/ee-done', [EmployeeController::class, 'eedone'])->name('ps.employees.ee-done');
Route::patch('/ps/employees/{employee}', [EmployeeController::class, 'update'])->name('ps.employees.update');
Route::get('/ps/employees/{employee}', [EmployeeController::class, 'show'])->name('ps.employees.show');
Route::get('/ps/employees', [EmployeeController::class, 'index'])->name('ps.employees');

Route::get('/ps/users/create', [UserController::class, 'create'])->name('ps.users.create');
Route::post('/ps/users', [UserController::class, 'store'])->name('ps.users.store');
Route::get('/ps/users', [UserController::class, 'index'])->name('ps.users');

Route::any('/ps/items/search', [ItemController::class, 'search'])->name('ps.items.search');
Route::get('/ps/items/create', [ItemController::class, 'create'])->name('ps.items.create');
Route::get('/ps/items/active', [ItemController::class, 'displayActive'])->name('ps.items.active');
Route::get('/ps/items/unfilled', [ItemController::class, 'displayUnfilled'])->name('ps.items.unfilled');
Route::get('/ps/items/deactivated', [ItemController::class, 'displayDeactivated'])->name('ps.items.deactivated');
Route::get('/ps/items/{item}/edit', [ItemController::class, 'edit'])->name('ps.items.edit');
Route::get('/ps/items/{item}/activate', [ItemController::class, 'activate'])->name('ps.items.activate');
Route::patch('/ps/items/{item}/activate-done', [ItemController::class, 'activatedone'])->name('ps.items.activate-done');
Route::get('/ps/items/{item}/deactivate', [ItemController::class, 'deactivate'])->name('ps.items.deactivate');
Route::patch('/ps/items/{item}/deactivate-done', [ItemController::class, 'deactivatedone'])->name('ps.items.deactivate-done');
Route::patch('/ps/items/{item}', [ItemController::class, 'update'])->name('ps.items.update');
Route::get('/ps/items/{item}', [ItemController::class, 'show'])->name('ps.items.show');
Route::post('/ps/items', [ItemController::class, 'store'])->name('ps.items.store');
Route::get('/ps/items', [ItemController::class, 'index'])->name('ps.items');

Route::any('/ps/search', [PSController::class, 'search'])->name('ps.search');
Route::get('/ps', [PSController::class, 'index'])->name('ps');


Route::get('/rs/employees/{employee}', [App\Http\Controllers\RS\EmployeeController::class, 'show'])->name('rs.employees.show');
Route::get('/rs/employees', [App\Http\Controllers\RS\EmployeeController::class, 'index'])->name('rs.employees');
Route::get('/rs', [RSController::class, 'index'])->name('rs');


Route::get('/station/{station}/employees/{employee}', [EmployeeController::class, 'show'])->name('station.employees.show');
Route::get('/station/{station}/employees', [EmployeeController::class, 'index'])->name('station.employees');
Route::get('/station/{station}', [StationController::class, 'index'])->name('station');

Route::get('/help', [HomeController::class, 'help'])->name('help');
