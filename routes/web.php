<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\DteController;


Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

Route::get('/invoices', [InvoicesController::class, 'index']
)->middleware('auth')->name('invoices.index');


Route::post('/upload-files', [FileUploadController::class, 'uploadFiles']);
Route::post("/enviar_dte", [MailController::class, "mandar_correo"])->name("invoices.send");
Route::get('/download-dtes', [DteController::class, 'downloadAndStoreDte'])->name("dtes.download");
