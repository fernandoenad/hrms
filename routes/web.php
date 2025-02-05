<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\PasswordSecurityController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\My\ContactController;
use App\Http\Controllers\My\AddressController;
use App\Http\Controllers\My\MyController;
use App\Http\Controllers\My\ToolController;
use App\Http\Controllers\My\EmployeeController as MyEmployeeController; 

use App\Http\Controllers\PS\PSController;
use App\Http\Controllers\PS\PersonController;
use App\Http\Controllers\PS\ItemController;
use App\Http\Controllers\PS\EmployeeController;
use App\Http\Controllers\PS\UserController;
use App\Http\Controllers\PS\ReportController;
use App\Http\Controllers\PS\RMSController as PSRMSController;
use App\Http\Controllers\PS\PostController;
use App\Http\Controllers\PS\VacancyController;
use App\Http\Controllers\PS\ApplicationController as PSApplicationController;

use App\Http\Controllers\RS\RSController;
use App\Http\Controllers\RS\EmployeeController as RSEmployeeController;
use App\Http\Controllers\RS\UserController as RSUserController;

use App\Http\Controllers\PU\PUController;
use App\Http\Controllers\PU\EmployeeController as PUEmployeeController;
use App\Http\Controllers\PU\StationController;
use App\Http\Controllers\PU\OfficeController;
use App\Http\Controllers\PU\TownController;
use App\Http\Controllers\PU\UserController as PUUserController;
use App\Http\Controllers\PU\ItemController as PUItemController;

use App\Http\Controllers\DPSU\DPSUController;
use App\Http\Controllers\DPSU\LoyaltyNotificationController;
use App\Http\Controllers\DPSU\NOSINotifController;
use App\Http\Controllers\DPSU\EmployeeController as DPSUEmployeeController;
use App\Http\Controllers\DPSU\UserController as DPSUUserController;

use App\Http\Controllers\ICTU\ICTUController;
use App\Http\Controllers\ICTU\PersonController as ICTUPersonController;
use App\Http\Controllers\ICTU\EmployeeController as ICTUEmployeeController;
use App\Http\Controllers\ICTU\UserRoleController;
use App\Http\Controllers\ICTU\UserRankingController;
use App\Http\Controllers\ICTU\UserController as ICTUUserController;
use App\Http\Controllers\ICTU\SupportController;
use App\Http\Controllers\ICTU\RequestController;

use App\Http\Controllers\RMS\RMSController;
use App\Http\Controllers\RMS\PersonController as RMSPersonController;
use App\Http\Controllers\RMS\ApplicationController;
use App\Http\Controllers\RMS\RMSAssignmentController;

use App\Http\Controllers\OU\OUController;
use App\Http\Controllers\OU\StationController as OUStationController;
use App\Http\Controllers\OU\STEmployeeController;
use App\Http\Controllers\OU\STLeaveController;
use App\Http\Controllers\OU\STApplicationController;
use App\Http\Controllers\OU\STApplication2Controller;
use App\Http\Controllers\OU\STAssessmentController;
use App\Http\Controllers\OU\STUserController;
use App\Http\Controllers\OU\STRankingController;
use App\Http\Controllers\OU\STPBBController;


use App\Http\Controllers\OU\OfficeController as OUSOfficeController;
use App\Http\Controllers\OU\OFUserController;
use App\Http\Controllers\OU\OFApplicationController;
use App\Http\Controllers\OU\OFApplication2Controller;
use App\Http\Controllers\OU\OFStationController;

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

Route::middleware(['record.log'])->group(function () {

Route::get('/', function () {
    return view('home.apps');
});

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/my');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

Auth::routes(['register' => false]);

Route::get('/my/tools/expired-password', [PasswordSecurityController::class, 'index'])->name('auth.expired-password');
Route::post('/my/tools/reset-password', [PasswordSecurityController::class, 'resetPassword'])->name('auth.reset-password');

Route::middleware(['default.password', 'verified'])->group(function () {
    Route::get('/rms/application/{vacancy}/apply', [ApplicationController::class, 'apply'])->name('rms.application.apply');
    Route::get('/rms/application/{application}/edit-doc', [ApplicationController::class, 'editdoc'])->name('rms.application.edit-doc');
    Route::patch('/rms/application/{application}/update-doc', [ApplicationController::class, 'updatedoc'])->name('rms.application.update-doc');
    Route::get('/rms/application/{application}', [ApplicationController::class, 'show'])->name('rms.application.show');
    Route::delete('/rms/application/{application}', [ApplicationController::class, 'destroy'])->name('rms.application.destroy');
    Route::post('/rms/application', [ApplicationController::class, 'store'])->name('rms.application.store');
    Route::get('/rms/application', [ApplicationController::class, 'index'])->name('rms.application');

    Route::get('/my/tools/password-edit', [ToolController::class, 'editPassword'])->name('my.tools.password-edit')->middleware('password.confirm');
    Route::patch('/my/tools/password', [ToolController::class, 'updatePassword'])->name('my.tools.password-update');
    Route::get('/my/tools/email-edit', [ToolController::class, 'editEmail'])->name('my.tools.email-edit')->middleware('password.confirm');
    Route::patch('/my/tools/email', [ToolController::class, 'updateEmail'])->name('my.tools.email-update');
    Route::get('/my/tools', [ToolController::class, 'index'])->name('my.tools');

    Route::patch('/my/tools/image', [ToolController::class, 'updateImage'])->name('my.tools.image-update');
    Route::get('/my/tools/image-edit', [ToolController::class, 'editImage'])->name('my.tools.image-edit');

    Route::get('my/contact/edit', [ContactController::class, 'edit'])->name('my.contact.edit');
    Route::patch('my/contact/update', [ContactController::class, 'update'])->name('my.contact.update');

    Route::get('my/address/edit', [AddressController::class, 'edit'])->name('my.address.edit');
    Route::patch('my/address/update', [AddressController::class, 'update'])->name('my.address.update');

    Route::get('/my', [MyController::class, 'index'])->name('my');


    Route::middleware(['role.ps'])->group(function () {
        Route::any('/ps/people/search', [PersonController::class, 'search'])->name('ps.people.search');
        Route::get('/ps/people/create', [PersonController::class, 'create'])->name('ps.people.create');
        Route::get('/ps/people/{person}/edit', [PersonController::class, 'edit'])->name('ps.people.edit');
        Route::get('/ps/people/{person}/employ', [PersonController::class, 'employ'])->name('ps.people.employ');
        Route::any('/ps/people/{person}/lookup-item', [PersonController::class, 'lookupItem'])->name('ps.people.lookup-item');
        Route::post('/ps/people/{person}/employ-done', [PersonController::class, 'employdone'])->name('ps.people.employ-done');
        Route::patch('/ps/people/{person}', [PersonController::class, 'update'])->name('ps.people.update');
        Route::get('/ps/people/{person}', [PersonController::class, 'show'])->name('ps.people.show');
        Route::post('/ps/people', [PersonController::class, 'store'])->name('ps.people.store');
        Route::get('/ps/people', [PersonController::class, 'index'])->name('ps.people');

        Route::any('/ps/employees/search', [EmployeeController::class, 'search'])->name('ps.employees.search');
        Route::get('/ps/employees/active', [EmployeeController::class, 'displayActive'])->name('ps.employees.active');
        Route::get('/ps/employees/unassigned', [EmployeeController::class, 'displayUnassigned'])->name('ps.employees.unassigned');
        Route::get('/ps/employees/terminated', [EmployeeController::class, 'displayTerminated'])->name('ps.employees.terminated');
        Route::get('/ps/employees/{employee}/show-logs', [EmployeeController::class, 'showlogs'])->name('ps.employees.show-logs');
        Route::get('/ps/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('ps.employees.edit');
        Route::get('/ps/employees/{employee}/si', [EmployeeController::class, 'si'])->name('ps.employees.si');
        Route::patch('/ps/employees/{employee}/si-done', [EmployeeController::class, 'sidone'])->name('ps.employees.si-done');
        Route::get('/ps/employees/{employee}/pr', [EmployeeController::class, 'pr'])->name('ps.employees.pr');
        Route::any('/ps/employees/{employee}/pr/lookup-item', [EmployeeController::class, 'lookupItem'])->name('ps.employees.lookup-item');    
        Route::patch('/ps/employees/{employee}/pr-done', [EmployeeController::class, 'prdone'])->name('ps.employees.pr-done');
        Route::get('/ps/employees/{employee}/ee', [EmployeeController::class, 'ee'])->name('ps.employees.ee');
        Route::patch('/ps/employees/{employee}/ee-done', [EmployeeController::class, 'eedone'])->name('ps.employees.ee-done');
        Route::patch('/ps/employees/{employee}', [EmployeeController::class, 'update'])->name('ps.employees.update');
        Route::get('/ps/employees/{employee}', [EmployeeController::class, 'show'])->name('ps.employees.show');
        Route::get('/ps/employees', [EmployeeController::class, 'index'])->name('ps.employees');

        Route::any('/ps/items/search', [ItemController::class, 'search'])->name('ps.items.search');
        Route::get('/ps/items/create', [ItemController::class, 'create'])->name('ps.items.create');
        Route::get('/ps/items/active', [ItemController::class, 'displayActive'])->name('ps.items.active');
        Route::get('/ps/items/unfilled', [ItemController::class, 'displayUnfilled'])->name('ps.items.unfilled');
        Route::get('/ps/items/deactivated', [ItemController::class, 'displayDeactivated'])->name('ps.items.deactivated');
        Route::get('/ps/items/{item}/edit', [ItemController::class, 'edit'])->name('ps.items.edit');
        Route::patch('/ps/items/{item}', [ItemController::class, 'update'])->name('ps.items.update');
        Route::get('/ps/items/{item}', [ItemController::class, 'show'])->name('ps.items.show');
        Route::post('/ps/items', [ItemController::class, 'store'])->name('ps.items.store');
        Route::get('/ps/items', [ItemController::class, 'index'])->name('ps.items');

        Route::get('/ps/rms/posts/show/{post}/edit', [PostController::class, 'edit'])->name('ps.rms.posts-edit');
        Route::delete('/ps/rms/posts/show/{post}', [PostController::class, 'destroy'])->name('ps.rms.posts-destroy');
        Route::patch('/ps/rms/posts/show/{post}', [PostController::class, 'update'])->name('ps.rms.posts-update');
        Route::get('/ps/rms/posts/show/{post}', [PostController::class, 'show'])->name('ps.rms.posts-show');
        Route::get('/ps/rms/posts/{type}', [PostController::class, 'type'])->name('ps.rms.posts');
        Route::get('/ps/rms/posts/create/{type}', [PostController::class, 'create'])->name('ps.rms.posts-create');
        Route::post('/ps/rms/posts', [PostController::class, 'store'])->name('ps.rms.posts-store');

        Route::get('/ps/rms/vacancies/create/', [VacancyController::class, 'create'])->name('ps.rms.vacancies-create');
        Route::get('/ps/rms/vacancies/{vacancy}/edit', [VacancyController::class, 'edit'])->name('ps.rms.vacancies-edit');
        Route::delete('/ps/rms/vacancies/{vacancy}', [VacancyController::class, 'destroy'])->name('ps.rms.vacancies-destroy');
        Route::patch('/ps/rms/vacancies/{vacancy}', [VacancyController::class, 'update'])->name('ps.rms.vacancies-update');            
        Route::get('/ps/rms/vacancies/{vacancy}', [VacancyController::class, 'show'])->name('ps.rms.vacancies-show');
        Route::get('/ps/rms/vacancies', [VacancyController::class, 'index'])->name('ps.rms.vacancies');
        Route::post('/ps/rms/vacancies', [VacancyController::class, 'store'])->name('ps.rms.vacancies-store');

        Route::get('/ps/rms/applications/needs-confirmation', [PSApplicationController::class, 'needsconfirmation'])->name('ps.rms.applications-needs-confirmation');
        Route::get('/ps/rms/applications/{cycle}/{vacancy}/vacancyfilter/{filter}/{page}', [PSApplicationController::class, 'vacancyfilter'])->name('ps.rms.applications-show-vacancyfilter');
        Route::get('/ps/rms/applications/{cycle}/{vacancy}/ranking/{ranking}', [PSApplicationController::class, 'deleteranking'])->name('ps.rms.applications-delete-ranking');
        Route::get('/ps/rms/applications/{cycle}/{vacancy}/ranking', [PSApplicationController::class, 'showranking'])->name('ps.rms.applications-show-ranking');
        Route::get('/ps/rms/applications/{cycle}/showfilter/{filter}/{page}', [PSApplicationController::class, 'showfilter'])->name('ps.rms.applications-show-showfilter');
        Route::get('/ps/rms/applications/{cycle}/{vacancy}/{application}/take-action', [PSApplicationController::class, 'takeaction'])->name('ps.rms.applications-show.take-action');
        Route::patch('/ps/rms/applications/{cycle}/{vacancy}/{application}', [PSApplicationController::class, 'actiontaken'])->name('ps.rms.applications-show.action-taken');
        Route::get('/ps/rms/applications/{cycle}/{vacancy}/{application}', [PSApplicationController::class, 'show'])->name('ps.rms.applications-show');
        Route::get('/ps/rms/applications/{cycle}/{vacancy}', [PSApplicationController::class, 'showvacancy'])->name('ps.rms.applications-show-vacancy');
        Route::get('/ps/rms/applications/{cycle}/', [PSApplicationController::class, 'showcycle'])->name('ps.rms.applications-show-cycle');
        Route::any('/ps/rms/applications/search', [PSApplicationController::class, 'search'])->name('ps.rms.applications-search');
        Route::get('/ps/rms/applications', [PSApplicationController::class, 'index'])->name('ps.rms.applications');
        Route::get('/ps/rms', [PSRMSController::class, 'index'])->name('ps.rms');

        Route::any('/ps/search', [PSController::class, 'search'])->name('ps.search');
        Route::get('/ps', [PSController::class, 'index'])->name('ps');

        Route::middleware(['access.ps'])->group(function () {
            Route::get('/ps/employees/{employee}/re-employ', [EmployeeController::class, 'confirmReemploy'])->name('ps.employees.re-employ');
            Route::patch('/ps/employees/{employee}/re-employ-done', [EmployeeController::class, 'processReemploy'])->name('ps.employees.re-employ-done');
            Route::get('/ps/employees/{employee}/confirm-delete', [EmployeeController::class, 'confirmDelete'])->name('ps.employees.confirm-delete');
            Route::delete('/ps/employees/{employee}', [EmployeeController::class, 'delete'])->name('ps.employees.delete');
            
            Route::any('/ps/reports/schools/{fiscalcategory}/search', [ReportController::class, 'searchSchool'])->name('ps.reports.schools-search');
            Route::get('/ps/reports/schools/{fiscalcategory}', [ReportController::class, 'fiscalcategory'])->name('ps.reports.schools');

            Route::get('/ps/reports/plantilla/{office}/{station}', [ReportController::class, 'plstation'])->name('ps.reports.plantilla.station');
            Route::get('/ps/reports/plantilla/{office}', [ReportController::class, 'ploffice'])->name('ps.reports.plantilla.office');
            Route::get('/ps/reports/plantilla', [ReportController::class, 'plantilla'])->name('ps.reports.plantilla');
                  
            Route::get('/ps/reports/deployment/{office}/{station}', [ReportController::class, 'destation'])->name('ps.reports.deployment.station');
            Route::get('/ps/reports/deployment/{office}', [ReportController::class, 'deoffice'])->name('ps.reports.deployment.office');
            Route::get('/ps/reports/deployment', [ReportController::class, 'deployment'])->name('ps.reports.deployment');

            Route::get('/ps/reports', [ReportController::class, 'index'])->name('ps.reports');

            Route::get('/ps/users/create', [UserController::class, 'create'])->name('ps.users.create');
            Route::any('/ps/users/search', [UserController::class, 'search'])->name('ps.users.search');
            Route::any('/ps/users/lookup', [UserController::class, 'lookup'])->name('ps.users.lookup');
            Route::get('/ps/users/{userrole}/edit', [UserController::class, 'edit'])->name('ps.users.edit');
            Route::get('/ps/users/{userrole}/confirm-delete', [UserController::class, 'confirmDelete'])->name('ps.users.confirm-delete');
            Route::delete('/ps/users/{userrole}', [UserController::class, 'delete'])->name('ps.users.delete');
            Route::patch('/ps/users/{userrole}', [UserController::class, 'update'])->name('ps.users.update');
            Route::get('/ps/users/{userrole}', [UserController::class, 'show'])->name('ps.users.show');
            Route::post('/ps/users', [UserController::class, 'store'])->name('ps.users.store');
            Route::get('/ps/users', [UserController::class, 'index'])->name('ps.users');

            Route::get('/ps/items/{item}/activate', [ItemController::class, 'activate'])->name('ps.items.activate');
            Route::patch('/ps/items/{item}/activate-done', [ItemController::class, 'activatedone'])->name('ps.items.activate-done');
            Route::get('/ps/items/{item}/deactivate', [ItemController::class, 'deactivate'])->name('ps.items.deactivate');
            Route::patch('/ps/items/{item}/deactivate-done', [ItemController::class, 'deactivatedone'])->name('ps.items.deactivate-done');
        });
    });


    Route::middleware(['role.rs'])->group(function () {
        Route::any('/rs/employees/search', [RSEmployeeController::class, 'search'])->name('rs.employees.search');
        Route::get('/rs/employees/active', [RSEmployeeController::class, 'displayActive'])->name('rs.employees.active');
        Route::get('/rs/employees/inactive', [RSEmployeeController::class, 'displayInactive'])->name('rs.employees.inactive');
        Route::get('/rs/employees/{employee}', [RSEmployeeController::class, 'show'])->name('rs.employees.show');
        Route::get('/rs/employees', [RSEmployeeController::class, 'index'])->name('rs.employees');

        Route::middleware(['access.rs'])->group(function () {
            Route::get('/rs/users/create', [RSUserController::class, 'create'])->name('rs.users.create');
            Route::any('/rs/users/search', [RSUserController::class, 'search'])->name('rs.users.search');
            Route::any('/rs/users/lookup', [RSUserController::class, 'lookup'])->name('rs.users.lookup');
            Route::get('/rs/users/{userrole}/edit', [RSUserController::class, 'edit'])->name('rs.users.edit');
            Route::get('/rs/users/{userrole}/confirm-delete', [RSUserController::class, 'confirmDelete'])->name('rs.users.confirm-delete');
            Route::delete('/rs/users/{userrole}', [RSUserController::class, 'delete'])->name('rs.users.delete');
            Route::patch('/rs/users/{userrole}', [RSUserController::class, 'update'])->name('rs.users.update');
            Route::get('/rs/users/{userrole}', [RSUserController::class, 'show'])->name('rs.users.show');
            Route::post('/rs/users', [RSUserController::class, 'store'])->name('rs.users.store');
            Route::get('/rs/users', [RSUserController::class, 'index'])->name('rs.users');
        });

        Route::get('/rs', [RSController::class, 'index'])->name('rs');
    });


    Route::middleware(['role.pu'])->group(function () {
        Route::any('/pu/employees/search', [PUEmployeeController::class, 'search'])->name('pu.employees.search');
        Route::get('/pu/employees/active', [PUEmployeeController::class, 'displayActive'])->name('pu.employees.active');
        Route::get('/pu/employees/inactive', [PUEmployeeController::class, 'displayInactive'])->name('pu.employees.inactive');
        Route::get('/pu/employees/{employee}', [PUEmployeeController::class, 'show'])->name('pu.employees.show');
        Route::get('/pu/employees', [PUEmployeeController::class, 'index'])->name('pu.employees');

        Route::any('/pu/stations/search', [StationController::class, 'search'])->name('pu.stations.search');
        Route::get('/pu/stations/create', [StationController::class, 'create'])->name('pu.stations.create');
        Route::any('/pu/stations/lookup', [StationController::class, 'lookup'])->name('pu.stations.lookup');
        Route::delete('/pu/stations/{station}', [StationController::class, 'delete'])->name('pu.stations.delete');
        Route::get('/pu/stations/{station}/edit', [StationController::class, 'edit'])->name('pu.stations.edit');
        Route::patch('/pu/stations/{station}', [StationController::class, 'update'])->name('pu.stations.update');
        Route::post('/pu/stations', [StationController::class, 'store'])->name('pu.stations.store');
        Route::get('/pu/stations', [StationController::class, 'index'])->name('pu.stations');

        Route::any('/pu/offices/search', [OfficeController::class, 'search'])->name('pu.offices.search');
        Route::get('/pu/offices/create', [OfficeController::class, 'create'])->name('pu.offices.create');
        Route::any('/pu/offices/lookup', [OfficeController::class, 'lookup'])->name('pu.offices.lookup');
        Route::delete('/pu/offices/{office}', [OfficeController::class, 'delete'])->name('pu.offices.delete');
        Route::get('/pu/offices/{office}/edit', [OfficeController::class, 'edit'])->name('pu.offices.edit');
        Route::patch('/pu/offices/{office}', [OfficeController::class, 'update'])->name('pu.offices.update');
        Route::post('/pu/offices', [OfficeController::class, 'store'])->name('pu.offices.store');
        Route::get('/pu/offices', [OfficeController::class, 'index'])->name('pu.offices');

        Route::any('/pu/towns/search', [TownController::class, 'search'])->name('pu.towns.search');
        Route::get('/pu/towns/create', [TownController::class, 'create'])->name('pu.towns.create');
        Route::delete('/pu/towns/{town}', [TownController::class, 'delete'])->name('pu.towns.delete');
        Route::get('/pu/towns/{town}/edit', [TownController::class, 'edit'])->name('pu.towns.edit');
        Route::patch('/pu/towns/{town}', [TownController::class, 'update'])->name('pu.towns.update');
        Route::post('/pu/towns', [TownController::class, 'store'])->name('pu.towns.store');
        Route::get('/pu/towns', [TownController::class, 'index'])->name('pu.towns');

        Route::any('/pu/items/search', [PUItemController::class, 'search'])->name('pu.items.search');
        Route::get('/pu/items/active', [PUItemController::class, 'displayActive'])->name('pu.items.active');
        Route::get('/pu/items/unfilled', [PUItemController::class, 'displayUnfilled'])->name('pu.items.unfilled');
        Route::get('/pu/items/unassigned', [PUItemController::class, 'displayUnassigned'])->name('pu.items.unassigned');
        Route::get('/pu/items/{item}/edit', [PUItemController::class, 'edit'])->name('pu.items.edit');
        Route::patch('/pu/items/{item}', [PUItemController::class, 'update'])->name('pu.items.update');
        Route::get('/pu/items/{item}', [PUItemController::class, 'show'])->name('pu.items.show');
        Route::get('/pu/items', [PUItemController::class, 'index'])->name('pu.items');

        Route::middleware(['access.pu'])->group(function () {
            Route::get('/pu/users/create', [PUUserController::class, 'create'])->name('pu.users.create');
            Route::any('/pu/users/search', [PUUserController::class, 'search'])->name('pu.users.search');
            Route::any('/pu/users/lookup', [PUUserController::class, 'lookup'])->name('pu.users.lookup');
            Route::get('/pu/users/{userrole}/edit', [PUUserController::class, 'edit'])->name('pu.users.edit');
            Route::get('/pu/users/{userrole}/confirm-delete', [PUUserController::class, 'confirmDelete'])->name('pu.users.confirm-delete');
            Route::delete('/pu/users/{userrole}', [PUUserController::class, 'delete'])->name('pu.users.delete');
            Route::patch('/pu/users/{userrole}', [PUUserController::class, 'update'])->name('pu.users.update');
            Route::get('/pu/users/{userrole}', [PUUserController::class, 'show'])->name('pu.users.show');
            Route::post('/pu/users', [PUUserController::class, 'store'])->name('pu.users.store');
            Route::get('/pu/users', [PUUserController::class, 'index'])->name('pu.users');
        });

        Route::get('/pu/{office}', [PUController::class, 'showOffice'])->name('pu.show');
        Route::get('/pu', [PUController::class, 'index'])->name('pu');
    });


    Route::middleware(['role.dpsu'])->group(function () {
        Route::any('/dpsu/employees/search', [DPSUEmployeeController::class, 'search'])->name('dpsu.employees.search');
        Route::get('/dpsu/employees/active', [DPSUEmployeeController::class, 'displayActive'])->name('dpsu.employees.active');
        Route::get('/dpsu/employees/inactive', [DPSUEmployeeController::class, 'displayInactive'])->name('dpsu.employees.inactive');
        Route::get('/dpsu/employees/{employee}', [DPSUEmployeeController::class, 'show'])->name('dpsu.employees.show');
        Route::get('/dpsu/employees', [DPSUEmployeeController::class, 'index'])->name('dpsu.employees');

        Route::any('/dpsu/nosi-notifications/search', [NOSINotifController::class, 'search'])->name('dpsu.nosi-notifications.search');
        Route::get('/dpsu/nosi-notifications', [NOSINotifController::class, 'index'])->name('dpsu.nosi-notifications');

        Route::any('/dpsu/loyalty-notifications/search', [LoyaltyNotificationController::class, 'search'])->name('dpsu.loyalty-notifications.search');
        Route::get('/dpsu/loyalty-notifications', [LoyaltyNotificationController::class, 'index'])->name('dpsu.loyalty-notifications');

        Route::middleware(['access.dpsu'])->group(function () {
            Route::get('/dpsu/users/create', [DPSUUserController::class, 'create'])->name('dpsu.users.create');
            Route::any('/dpsu/users/search', [DPSUUserController::class, 'search'])->name('dpsu.users.search');
            Route::any('/dpsu/users/lookup', [DPSUUserController::class, 'lookup'])->name('dpsu.users.lookup');
            Route::get('/dpsu/users/{userrole}/edit', [DPSUUserController::class, 'edit'])->name('dpsu.users.edit');
            Route::get('/dpsu/users/{userrole}/confirm-delete', [DPSUUserController::class, 'confirmDelete'])->name('dpsu.users.confirm-delete');
            Route::delete('/dpsu/users/{userrole}', [DPSUUserController::class, 'delete'])->name('dpsu.users.delete');
            Route::patch('/dpsu/users/{userrole}', [DPSUUserController::class, 'update'])->name('dpsu.users.update');
            Route::get('/dpsu/users/{userrole}', [DPSUUserController::class, 'show'])->name('dpsu.users.show');
            Route::post('/dpsu/users', [DPSUUserController::class, 'store'])->name('dpsu.users.store');
            Route::get('/dpsu/users', [DPSUUserController::class, 'index'])->name('dpsu.users');
        });

        Route::get('/dpsu', [DPSUController::class, 'index'])->name('dpsu');
    });


    Route::middleware(['role.ictu'])->group(function () {
        Route::get('/ictu/people/non-employees', [ICTUPersonController::class, 'nonemployees'])->name('ictu.people.non-employees');
        Route::any('/ictu/people/search', [ICTUPersonController::class, 'search'])->name('ictu.people.search');
        Route::get('/ictu/people/{person}/edit-credentials', [ICTUPersonController::class, 'editcredentials'])->name('ictu.people.edit-credentials');
        Route::post('/ictu/people/{person}', [ICTUPersonController::class, 'updatecredentials'])->name('ictu.people.update-credentials');
        Route::get('/ictu/people/{person}/reset', [ICTUPersonController::class, 'reset'])->name('ictu.people.reset');
        Route::patch('/ictu/people/{person}', [ICTUPersonController::class, 'update'])->name('ictu.people.update');
        Route::get('/ictu/people/{person}', [ICTUPersonController::class, 'show'])->name('ictu.people.show');
        Route::get('/ictu/people', [ICTUPersonController::class, 'index'])->name('ictu.people');

        Route::any('/ictu/employees/search', [ICTUEmployeeController::class, 'search'])->name('ictu.employees.search');
        Route::get('/ictu/employees/{employee}', [ICTUEmployeeController::class, 'show'])->name('ictu.employees.show');
        Route::get('/ictu/employees', [ICTUEmployeeController::class, 'index'])->name('ictu.employees');

        Route::any('/ictu/support/search', [SupportController::class, 'search'])->name('ictu.support.search');
        Route::get('/ictu/support/create', [SupportController::class, 'create'])->name('ictu.support.create');
        Route::get('/ictu/support/{post}/edit', [SupportController::class, 'edit'])->name('ictu.support.edit');
        Route::delete('/ictu/support/{post}', [SupportController::class, 'destroy'])->name('ictu.support.destroy');
        Route::patch('/ictu/support/{post}', [SupportController::class, 'update'])->name('ictu.support.update');
        Route::get('/ictu/support/{post}', [SupportController::class, 'show'])->name('ictu.support.show');
        Route::post('/ictu/support', [SupportController::class, 'store'])->name('ictu.support.store');
        Route::get('/ictu/support', [SupportController::class, 'index'])->name('ictu.support');

        Route::get('/ictu/requests/new-counter', [RequestController::class, 'getNewCounter'])->name('ictu.requests.new-counter');
        Route::any('/ictu/requests/activations', [RequestController::class, 'activations'])->name('ictu.requests.activations');
        Route::any('/ictu/requests/search', [RequestController::class, 'search'])->name('ictu.requests.search');
        Route::get('/ictu/requests/display-new', [RequestController::class, 'display'])->name('ictu.requests.display-new');
        Route::get('/ictu/requests/display-pending', [RequestController::class, 'display'])->name('ictu.requests.display-pending');
        Route::get('/ictu/requests/display-resolved', [RequestController::class, 'display'])->name('ictu.requests.display-resolved');
        Route::get('/ictu/requests/{accountrequest}', [RequestController::class, 'edit'])->name('ictu.requests.edit');
        Route::patch('/ictu/requests/{accountrequest}', [RequestController::class, 'update'])->name('ictu.requests.update');
        Route::get('/ictu/requests/{accountrequest}/reset-password', [RequestController::class, 'resetpassword'])->name('ictu.requests.reset-password');

        Route::get('/ictu/requests', [RequestController::class, 'index'])->name('ictu.requests');

        Route::get('/ictu/roles/create', [UserRoleController::class, 'create'])->name('ictu.roles.create');
        Route::any('/ictu/roles/search', [UserRoleController::class, 'search'])->name('ictu.roles.search');
        Route::any('/ictu/roles/lookup', [UserRoleController::class, 'lookup'])->name('ictu.roles.lookup');
        Route::get('/ictu/roles/{userrole}/edit', [UserRoleController::class, 'edit'])->name('ictu.roles.edit');
        Route::get('/ictu/roles/{userrole}/confirm-delete', [UserRoleController::class, 'confirmDelete'])->name('ictu.roles.confirm-delete');
        Route::delete('/ictu/roles/{userrole}', [UserRoleController::class, 'delete'])->name('ictu.roles.delete');
        Route::patch('/ictu/roles/{userrole}', [UserRoleController::class, 'update'])->name('ictu.roles.update');
        Route::get('/ictu/roles/{userrole}', [UserRoleController::class, 'show'])->name('ictu.roles.show');
        Route::post('/ictu/roles', [UserRoleController::class, 'store'])->name('ictu.roles.store');
        Route::get('/ictu/roles', [UserRoleController::class, 'index'])->name('ictu.roles');

        Route::delete('/ictu/userranking/{userranking}/', [UserRankingController::class, 'destroy'])->name('ictu.userranking.destroy');
        Route::any('/ictu/userranking/lookup', [UserRankingController::class, 'lookup'])->name('ictu.userranking.lookup');
        Route::get('/ictu/userranking/create', [UserRankingController::class, 'create'])->name('ictu.userranking.create');
        Route::post('/ictu/userranking', [UserRankingController::class, 'store'])->name('ictu.userranking.store');
        Route::get('/ictu/userranking', [UserRankingController::class, 'index'])->name('ictu.userranking');

        Route::middleware(['access.ictu'])->group(function () {
            Route::get('/ictu/requests/{accountrequest}/verify-email', [RequestController::class, 'verifyemail'])->name('ictu.requests.verify-email');

            Route::get('/ictu/people/{person}/delete', [ICTUPersonController::class, 'delete'])->name('ictu.people.delete');
            Route::delete('/ictu/people/{person}', [ICTUPersonController::class, 'destroy'])->name('ictu.people.destroy');
     
            Route::get('/ictu/users/create', [ICTUUserController::class, 'create'])->name('ictu.users.create');
            Route::any('/ictu/users/search', [ICTUUserController::class, 'search'])->name('ictu.users.search');
            Route::any('/ictu/users/lookup', [ICTUUserController::class, 'lookup'])->name('ictu.users.lookup');
            Route::get('/ictu/users/{userrole}/edit', [ICTUUserController::class, 'edit'])->name('ictu.users.edit');
            Route::get('/ictu/users/{userrole}/confirm-delete', [ICTUUserController::class, 'confirmDelete'])->name('ictu.users.confirm-delete');
            Route::delete('/ictu/users/{userrole}', [ICTUUserController::class, 'delete'])->name('ictu.users.delete');
            Route::patch('/ictu/users/{userrole}', [ICTUUserController::class, 'update'])->name('ictu.users.update');
            Route::get('/ictu/users/{userrole}', [ICTUUserController::class, 'show'])->name('ictu.users.show');
            Route::post('/ictu/users', [ICTUUserController::class, 'store'])->name('ictu.users.store');
            Route::get('/ictu/users', [ICTUUserController::class, 'index'])->name('ictu.users');
        });

        Route::get('/ictu', [ICTUController::class, 'index'])->name('ictu');
    });

    Route::middleware(['station.user'])->group(function () {
        Route::get('/ou/station/{station}/employees/add', [STEmployeeController::class, 'add'])->name('ou.station.employees.add');
        Route::get('/ou/station/{station}/employees/add2', [STEmployeeController::class, 'add2'])->name('ou.station.employees.add2');
        Route::any('/ou/station/{station}/employees/lookup', [STEmployeeController::class, 'lookup'])->name('ou.station.employees.lookup');
        Route::any('/ou/station/{station}/employees/lookup2', [STEmployeeController::class, 'lookup2'])->name('ou.station.employees.lookup2');
        Route::any('/ou/station/{station}/employees/search', [STEmployeeController::class, 'search'])->name('ou.station.employees.search');
        Route::get('/ou/station/{station}/employees/items/{pagination}', [STEmployeeController::class, 'items'])->name('ou.station.employees.items');
        Route::get('/ou/station/{station}/employees/plantilla/{pagination}', [STEmployeeController::class, 'plantilla'])->name('ou.station.employees.plantilla');
        Route::get('/ou/station/{station}/employees/filter/{position}', [STEmployeeController::class, 'filter'])->name('ou.station.employees.filter');
        Route::get('/ou/station/{station}/employees/{employee}', [STEmployeeController::class, 'show'])->name('ou.station.employees.show');
        Route::get('/ou/station/{station}/employees/{employee}/service-credits', [STEmployeeController::class, 'servicecredits'])->name('ou.station.employees.service-credits');
        Route::get('/ou/station/{station}/employees/{employee}/edit', [STEmployeeController::class, 'edit'])->name('ou.station.employees.edit');
        Route::get('/ou/station/{station}/employees/{employee}/move', [STEmployeeController::class, 'move'])->name('ou.station.employees.move');
        Route::patch('/ou/station/{station}/employees/{employee}/moved', [STEmployeeController::class, 'moved'])->name('ou.station.employees.moved');
        Route::patch('/ou/station/{station}/employees/{employee}', [STEmployeeController::class, 'update'])->name('ou.station.employees.update');
        Route::post('/ou/station/{station}/employees', [STEmployeeController::class, 'store'])->name('ou.station.employees.store');
        Route::post('/ou/station/{station}/employees/add', [STEmployeeController::class, 'store2'])->name('ou.station.employees.store2');
        Route::get('/ou/station/{station}/employees', [STEmployeeController::class, 'index'])->name('ou.station.employees');
        
        Route::get('/ou/station/{station}/leaves', [STLeaveController::class, 'index'])->name('ou.station.leaves');

        /*
        Route::get('/ou/station/{station}/applications/needs-confirmation', [STApplicationController::class, 'needsconfirmation'])->name('ou.station.applications.needs-confirmation');
        Route::get('/ou/station/{station}/applications/{cycle}/{vacancy}/upload-ranklist', [STApplicationController::class, 'uploadranklist'])->name('ou.station.applications.upload-ranklist');
        Route::post('/ou/station/{station}/applications/{cycle}/{vacancy}/uploaded-ranklist', [STApplicationController::class, 'uploadedranklist'])->name('ou.station.applications.uploaded-ranklist');
        Route::get('/ou/station/{station}/applications/{cycle}/{vacancy}/{application}/take-action', [STApplicationController::class, 'takeaction'])->name('ou.station.applications.show.take-action');
        Route::patch('/ou/station/{station}/applications/{cycle}/{vacancy}/{application}', [STApplicationController::class, 'actiontaken'])->name('ou.station.applications.show.action-taken');
        Route::get('/ou/station/{station}/applications/{cycle}/{vacancy}/{application}', [STApplicationController::class, 'show'])->name('ou.station.applications.show');
        Route::get('/ou/station/{station}/applications/{cycle}/{vacancy}', [STApplicationController::class, 'showvacancy'])->name('ou.station.applications.showvacancy');
        */

        Route::get('/ou/station/{station}/applications/{cycle}', [STApplication2Controller::class, 'showCycle'])->name('ou.station.applications.showcycle');
        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}', [STApplication2Controller::class, 'showVacancy'])->name('ou.station.applications.showvacancy');
        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/carview', [STApplication2Controller::class, 'carView'])->name('ou.station.applications.showvacancy.carview');
        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/ieraview', [STApplication2Controller::class, 'ierAView'])->name('ou.station.applications.showvacancy.ieraview');
        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/ierbview', [STApplication2Controller::class, 'ierBView'])->name('ou.station.applications.showvacancy.ierbview');
        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/ies', [STApplication2Controller::class, 'iesView'])->name('ou.station.applications.showvacancy.iesview');
        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/pdf', [STApplication2Controller::class, 'pdf'])->name('ou.station.applications.showvacancy.pdf');
        Route::get('/ou/station/{station}/applications', [STApplication2Controller::class, 'index'])->name('ou.station.applications');
        Route::get('/ou/station/{station}/applications/{cycle}/takein', [STApplication2Controller::class, 'takeIn'])->name('ou.station.applications.takein');
        Route::post('/ou/station/{station}/applications/{cycle}/takein', [STApplication2Controller::class, 'showResult'])->name('ou.station.applications.showresult');
        Route::post('/ou/station/{station}/applications/{cycle}/{application}', [STApplication2Controller::class, 'takeInOk'])->name('ou.station.applications.takeinok');

        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/{application}/withdraw', [STApplication2Controller::class, 'withdraw'])->name('ou.station.applications.withdraw');
        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/{application}', [STApplication2Controller::class, 'show'])->name('ou.station.applications.show');
        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/{application}/edit', [STApplication2Controller::class, 'edit'])->name('ou.station.applications.edit');
        Route::put('/ou/station/{station}/applications/{cycle}/list/{vacancy}/{application}', [STApplication2Controller::class, 'update'])->name('ou.station.applications.update');
        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/{application}/revert', [STApplication2Controller::class, 'revert'])->name('ou.station.applications.revert');

        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/{application}/assess', [STAssessmentController::class, 'index'])->name('ou.station.applications.assess.index');
        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/{application}/assess2', [STAssessmentController::class, 'index2'])->name('ou.station.applications.assess.index2');
        Route::put('/ou/station/{station}/applications/{cycle}/list/{vacancy}/{application}/{assessment}', [STAssessmentController::class, 'update'])->name('ou.station.applications.assess.update');
        Route::get('/ou/station/{station}/applications/{cycle}/list/{vacancy}/{application}/{assessment}/mark_complete', [STAssessmentController::class, 'markComplete'])->name('ou.station.applications.assess.markcomplete');


        Route::get('/ou/station/{station}/pbb/{year}', [STPBBController::class, 'index'])->name('ou.station.pbb');
        Route::post('/ou/station/{station}/pbb/{year}/', [STPBBController::class, 'store'])->name('ou.station.pbb.store');
        Route::get('/ou/station/{station}/pbb/{year}/add', [STPBBController::class, 'add'])->name('ou.station.pbb.add');
        Route::any('/ou/station/{station}/pbb/{year}/lookup', [STPBBController::class, 'lookup'])->name('ou.station.pbb.lookup');
        Route::get('/ou/station/{station}/pbb/{year}/{pbbreport}/edit', [STPBBController::class, 'edit'])->name('ou.station.pbb.edit');
        Route::get('/ou/station/{station}/pbb/{year}/{pbbreport}/delete', [STPBBController::class, 'delete'])->name('ou.station.pbb.delete');
        Route::delete('/ou/station/{station}/pbb/{year}/{pbbreport}/destroy', [STPBBController::class, 'destroy'])->name('ou.station.pbb.destroy');
        Route::any('/ou/station/{station}/pbb/{year}/search', [STPBBController::class, 'search'])->name('ou.station.pbb.search');

        Route::get('/ou/station/{station}/users/create', [STUserController::class, 'create'])->name('ou.station.users.create');
        Route::any('/ou/station/{station}/users/lookup', [STUserController::class, 'lookup'])->name('ou.station.users.lookup');
        Route::post('/ou/station/{station}/users', [STUserController::class, 'store'])->name('ou.station.users.store');
        Route::delete('/ou/station/{station}/users/{userst}', [STUserController::class, 'destroy'])->name('ou.station.users.destroy');
        Route::get('/ou/station/{station}/users', [STUserController::class, 'index'])->name('ou.station.users');

        Route::get('/ou/station/{station}', [OUStationController::class, 'index'])->name('ou.station.show');
        
    });    
    
    Route::get('/ou/station/', [OUController::class, 'station'])->name('ou.station');
    
    Route::middleware(['office.user'])->group(function () {
        /*
        Route::get('/ou/office/{office}/applications/needs-confirmation', [OFApplicationController::class, 'needsconfirmation'])->name('ou.office.applications.needs-confirmation');
        Route::get('/ou/office/{office}/applications/{cycle}/{vacancy}/upload-ranklist', [OFApplicationController::class, 'uploadranklist'])->name('ou.office.applications.upload-ranklist');
        Route::post('/ou/office/{office}/applications/{cycle}/{vacancy}/uploaded-ranklist', [OFApplicationController::class, 'uploadedranklist'])->name('ou.office.applications.uploaded-ranklist');
        Route::get('/ou/office/{office}/applications/{cycle}/{vacancy}/{application}/take-action', [OFApplicationController::class, 'takeaction'])->name('ou.office.applications.show.take-action');
        Route::patch('/ou/office/{office}/applications/{cycle}/{vacancy}/{application}', [OFApplicationController::class, 'actiontaken'])->name('ou.office.applications.show.action-taken');
        Route::get('/ou/office/{office}/applications/{cycle}/{vacancy}/{application}', [OFApplicationController::class, 'show'])->name('ou.office.applications.show');
        Route::get('/ou/office/{office}/applications/{cycle}/{vacancy}', [OFApplicationController::class, 'showvacancy'])->name('ou.office.applications.showvacancy');
        Route::get('/ou/office/{office}/applications/{cycle}', [OFApplicationController::class, 'showcycle'])->name('ou.office.applications.showcycle');
        Route::get('/ou/office/{office}/applications', [OFApplicationController::class, 'index'])->name('ou.office.applications');
        */ 
        Route::get('/ou/office/{office}/applications', [OFApplication2Controller::class, 'index'])->name('ou.office.applications.index');
        Route::get('/ou/office/{office}/applications/{cycle}/list/{vacancy}', [OFApplication2Controller::class, 'show'])->name('ou.office.applications.show');
        Route::get('/ou/office/{office}/applications/{cycle}/list/{vacancy}/carview', [OFApplication2Controller::class, 'carview'])->name('ou.office.applications.carview');
        Route::get('/ou/office/{office}/applications/{cycle}/list/{vacancy}/{application}', [OFApplication2Controller::class, 'assess'])->name('ou.office.applications.assess');
        Route::put('/ou/office/{office}/applications/{cycle}/list/{vacancy}/{application}', [OFApplication2Controller::class, 'update'])->name('ou.office.applications.update');
        Route::get('/ou/office/{office}/applications/{cycle}/list/{vacancy}/{application}/disqualify', [OFApplication2Controller::class, 'disqualify'])->name('ou.office.applications.disqualify');
        Route::get('/ou/office/{office}/applications/{cycle}/list/{vacancy}/{application}/mark/{score}', [OFApplication2Controller::class, 'mark'])->name('ou.office.applications.mark');
        Route::get('/ou/office/{office}/applications/{cycle}/list/{vacancy}/{application}/unmark', [OFApplication2Controller::class, 'unmark'])->name('ou.office.applications.unmark');

        Route::get('/ou/office/{office}/applications/{cycle}/um', [OFApplication2Controller::class, 'umIndex'])->name('ou.office.applications.umindex');
        Route::post('/ou/office/{office}/applications/{cycle}/um', [OFApplication2Controller::class, 'umLookup'])->name('ou.office.applications.umlookup');
        Route::get('/ou/office/{office}/applications/{cycle}/um/{application}', [OFApplication2Controller::class, 'umProcess'])->name('ou.office.applications.umprocess');

        Route::any('/ou/office/{office}/stations/{station}/lookup', [OFStationController::class, 'lookup'])->name('ou.office.stations.lookup');
        Route::get('/ou/office/{office}/stations/{station}/edit', [OFStationController::class, 'edit'])->name('ou.office.stations.edit');
        Route::patch('/ou/office/{office}/stations/{station}/edit', [OFStationController::class, 'update'])->name('ou.office.stations.update');
        Route::get('/ou/office/{office}/stations', [OFStationController::class, 'index'])->name('ou.office.stations');

        Route::get('/ou/office/{office}/users/create', [OFUserController::class, 'create'])->name('ou.office.users.create');
        Route::any('/ou/office/{office}/users/lookup', [OFUserController::class, 'lookup'])->name('ou.office.users.lookup');
        Route::delete('/ou/office/{office}/users/{userof}', [OFUserController::class, 'destroy'])->name('ou.office.users.destroy');
        Route::post('/ou/office/{office}/users', [OFUserController::class, 'store'])->name('ou.office.users.store');
        Route::get('/ou/office/{office}/users', [OFUserController::class, 'index'])->name('ou.office.users');

        Route::get('/ou/office/{office}/pw', [OFUserController::class, 'pwIndex'])->name('ou.office.pw.index');
        Route::post('/ou/office/{office}/pw', [OFUserController::class, 'pwLookup'])->name('ou.office.pw.lookup');
        Route::get('/ou/office/{office}/pw/{user}', [OFUserController::class, 'pwReset'])->name('ou.office.pw.reset');

        Route::get('/ou/office/{office}', [OUSOfficeController::class, 'index'])->name('ou.office.show');
    });

    Route::get('/ou/office/', [OUController::class, 'office'])->name('ou.office');

    Route::get('/ou', [OUController::class, 'index'])->name('ou');

});



Route::post('/rms/register/request', [RMSPersonController::class, 'request'])->name('rms.account.request');
Route::get('/rms/register', [RMSPersonController::class, 'index'])->name('rms.account.register');
Route::post('/rms/register', [RMSPersonController::class, 'store'])->name('rms.account.store');

/*
Route::get('/rms/vacancy/{vacancy}/ranking/{filter}', [RMSAssignmentController::class, 'showRanking'])->name('rms.vacancy.show.ranking');
Route::get('/rms/vacancy/{vacancy}/{filter}', [RMSAssignmentController::class, 'show'])->name('rms.vacancy.show');
Route::get('/rms/vacancy', [RMSAssignmentController::class, 'index'])->name('rms.vacancy');


Route::get('/rms/p/{page}', [RMSController::class, 'show'])->name('rms.show');
Route::get('/rms/post/{post}', [RMSController::class, 'display'])->name('rms.display');
Route::get('/rms', [RMSController::class, 'index'])->name('rms');
*/ 

Route::get('/help/request', [HomeController::class, 'lookup'])->name('help.track-requests');
Route::post('/help/request', [HomeController::class, 'track'])->name('help.track-request');

Route::any('/help/search', [HomeController::class, 'search'])->name('help.search');

Route::get('/help', [HomeController::class, 'help'])->name('help');

});