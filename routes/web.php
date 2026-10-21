<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest')->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('/demo', [DemoController::class, 'enter'])->middleware(['throttle:60,1', 'module:dashboard'])->name('demo.enter');

Route::middleware(['auth', 'super-admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [SuperAdminController::class, 'index'])->name('dashboard');
    Route::get('/demo-users/{demoVisitor}', [SuperAdminController::class, 'showDemoVisitor'])->name('demo-users.show');
    Route::post('/admins', [SuperAdminController::class, 'storeAdmin'])->middleware('throttle:10,1')->name('admins.store');
    Route::put('/modules', [SuperAdminController::class, 'updateModules'])->name('modules.update');
});

// CRM Web Application Routes
Route::middleware('auth')->group(function (): void {
    Route::get('/', fn () => view('crm.dashboard'))->middleware('module:dashboard')->name('dashboard');

    Route::get('/leads', function () {
        return view('crm.leads');
    })->middleware('module:leads')->name('leads');

    Route::get('/contacts', function () {
        return view('crm.contacts');
    })->middleware('module:contacts')->name('contacts');

    Route::get('/companies', function () {
        return view('crm.companies');
    })->middleware('module:companies')->name('companies');

    Route::get('/deals', function () {
        return view('crm.deals');
    })->middleware('module:deals')->name('deals');

    Route::get('/pipeline', function () {
        return view('crm.pipeline');
    })->middleware('module:pipeline')->name('pipeline');

    Route::get('/tasks', function () {
        return view('crm.tasks');
    })->middleware('module:tasks')->name('tasks');

    Route::get('/calendar', function () {
        return view('crm.calendar');
    })->middleware('module:calendar')->name('calendar');

    Route::get('/activities', function () {
        return view('crm.activities');
    })->middleware('module:activities')->name('activities');

    Route::get('/reports', function () {
        return view('crm.reports');
    })->middleware('module:reports')->name('reports');

    Route::get('/reports/modules', [ReportController::class, 'moduleIndex'])->middleware('module:reports')->name('reports.modules');
    Route::get('/reports/modules/{module}', [ReportController::class, 'module'])->where('module', '[a-z]+')->middleware('module:reports')->name('reports.module');
    Route::get('/reports/daily', [ReportController::class, 'daily'])->middleware('module:reports')->name('reports.daily');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->middleware('module:reports')->name('reports.monthly');
    Route::get('/reports/tasks', [ReportController::class, 'tasks'])->middleware('module:reports')->name('reports.tasks');
    Route::get('/reports/activities', [ReportController::class, 'activities'])->middleware('module:reports')->name('reports.activities');
    Route::get('/reports/export/{type}/{module?}', [ReportController::class, 'export'])->where(['type' => '[a-z]+', 'module' => '[a-z]+'])->middleware('module:reports')->name('reports.export');

    Route::get('/expenses', [ExpenseController::class, 'index'])->middleware('module:expenses')->name('expenses');
    Route::post('/expenses', [ExpenseController::class, 'store'])->middleware('module:expenses')->name('expenses.store');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->middleware('module:expenses')->name('expenses.destroy');

    Route::get('/automation', function () {
        return view('crm.automation');
    })->middleware('module:automation')->name('automation');

    Route::get('/team', function () {
        return view('crm.team');
    })->middleware('module:team')->name('team');

    Route::get('/settings', function () {
        return view('crm.settings');
    })->middleware('module:settings')->name('settings');
});

Route::middleware('throttle:120,1')->prefix('demo')->name('demo.')->group(function (): void {
    Route::post('/exit', [DemoController::class, 'exit'])->name('exit');
    Route::post('/activity', [DemoController::class, 'trackAction'])->name('activity');
    Route::post('/{module}/records', [DemoController::class, 'storeRecord'])->where('module', '[a-z]+')->name('records.store');
    Route::delete('/{module}/records/{record}', [DemoController::class, 'destroyRecord'])->where('module', '[a-z]+')->name('records.destroy');
    Route::get('/page/{page}', [DemoController::class, 'track'])->where('page', '[a-z]+')->name('track');
    Route::get('/dashboard', function (DemoController $controller, Request $request) {
        if (! $controller->touchPage($request, 'dashboard')) {
            return redirect()->route('demo.enter');
        }

        return $controller->dashboard($request);
    })->middleware('module:dashboard')->name('dashboard');
    foreach (['leads', 'contacts', 'companies', 'deals', 'pipeline', 'tasks', 'calendar', 'activities', 'reports', 'automation', 'team', 'settings'] as $page) {
        Route::get('/'.$page, function (DemoController $controller, Request $request) use ($page) {
            if (! $controller->touchPage($request, $page)) {
                return redirect()->route('demo.enter');
            }

            return view('crm.'.$page, $controller->recordsFor($request, $page));
        })->middleware('module:'.$page)->name($page);
    }

    Route::get('/expenses', [ExpenseController::class, 'index'])->middleware('module:expenses')->name('expenses');
    Route::post('/expenses', [ExpenseController::class, 'store'])->middleware('module:expenses')->name('expenses.store');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->middleware('module:expenses')->name('expenses.destroy');

    Route::get('/reports/modules', [ReportController::class, 'moduleIndex'])->middleware('module:reports')->name('reports.modules');
    Route::get('/reports/modules/{module}', [ReportController::class, 'module'])->where('module', '[a-z]+')->middleware('module:reports')->name('reports.module');
    Route::get('/reports/daily', [ReportController::class, 'daily'])->middleware('module:reports')->name('reports.daily');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->middleware('module:reports')->name('reports.monthly');
    Route::get('/reports/tasks', [ReportController::class, 'tasks'])->middleware('module:reports')->name('reports.tasks');
    Route::get('/reports/activities', [ReportController::class, 'activities'])->middleware('module:reports')->name('reports.activities');
    Route::get('/reports/export/{type}/{module?}', [ReportController::class, 'export'])->where(['type' => '[a-z]+', 'module' => '[a-z]+'])->middleware('module:reports')->name('reports.export');
});
