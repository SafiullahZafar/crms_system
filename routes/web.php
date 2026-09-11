<?php

use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// CRM Web Application Routes
Route::get('/', function () {
    return view('crm.dashboard');
})->name('dashboard');

Route::get('/leads', function () {
    return view('crm.leads');
})->name('leads');

Route::get('/contacts', function () {
    return view('crm.contacts');
})->name('contacts');

Route::get('/companies', function () {
    return view('crm.companies');
})->name('companies');

Route::get('/deals', function () {
    return view('crm.deals');
})->name('deals');

Route::get('/pipeline', function () {
    return view('crm.pipeline');
})->name('pipeline');

Route::get('/tasks', function () {
    return view('crm.tasks');
})->name('tasks');

Route::get('/calendar', function () {
    return view('crm.calendar');
})->name('calendar');

Route::get('/activities', function () {
    return view('crm.activities');
})->name('activities');

Route::get('/reports', function () {
    return view('crm.reports');
})->name('reports');

Route::get('/automation', function () {
    return view('crm.automation');
})->name('automation');

Route::get('/team', function () {
    return view('crm.team');
})->name('team');

Route::get('/settings', function () {
    return view('crm.settings');
})->name('settings');
