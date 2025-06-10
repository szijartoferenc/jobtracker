<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationLogController;

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

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/applications/stats', [ApplicationController::class, 'stats'])->name('applications.stats');

    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
    Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');
    Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');

    Route::get('/applications/export/csv', [ApplicationController::class, 'exportCsv'])->name('applications.export.csv');
    Route::get('/applications/export/pdf', [ApplicationController::class, 'exportPdf'])->name('applications.export.pdf');

    Route::post('/applications/{application}/logs', [ApplicationLogController::class, 'store'])->name('applications.logs.store');

    Route::get('/applications/{application}/download/{file}', [ApplicationController::class, 'download'])->name('applications.download');

    Route::post('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::post('/applications/{id}/notes', [ApplicationController::class, 'addNote'])->name('applications.addNote');

});


require __DIR__.'/auth.php';
