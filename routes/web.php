<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PromoterController;
use App\Http\Controllers\noAuthPromoterController;
use App\Http\Controllers\vCardController;
use App\Http\Controllers\IndexController;

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

Route::get('/', [IndexController::class, 'index'])->middleware(['auth']);
// rotta per utente che scannerizza qr code per vedere dettaglio promoter
//Route::get('/showcase', [vCardController::class, 'index'])->name('showcase.index');

Route::get('/bdv/{code}/scheda', [vCardController::class, 'scheda'])->name('bdv.scheda');
Route::get('/bdv/{code}/vcard', [vCardController::class, 'vcard'])->name('bdv.vcard');
Route::get('/bdv/{code}/pdf', [vCardController::class, 'pdf'])->name('bdv.pdf');

Route::get('/bdv/{code}', [vCardController::class, 'show'])->name('bdv.show');

// rotte per gestire il singolo accesso tramite mail

//Route::post('/singleAccess', [noAuthPromoterController::class, 'index'])->name('singleAccess.index');
//Route::get('/singleAccess', [noAuthPromoterController::class, 'logout'])->name('singleAccess.logout');
//Route::get('/singleAccess/{id}', [noAuthPromoterController::class, 'show'])->name('singleAccess.show');
//Route::get('/singleAccess/{id}/edit', [noAuthPromoterController::class, 'edit'])->name('singleAccess.edit');
//Route::patch('/singleAccess/{id}', [noAuthPromoterController::class, 'update'])->name('singleAccess.update');
//Route::get('/singleAccess/{id}/dropFile', [noAuthPromoterController::class, 'dropFile'])->name('singleAccess.dropFile');

//Route::post('/singleAccess/login', [noAuthPromoterController::class, 'login'])->name('singleAccess.login');
//Route::get('/singleAccess/sign-in/{user}', [noAuthPromoterController::class, 'signIn'])->name('singleAccess.sign-in');



// rotte per gestione dei promoter
// index
Route::get('/promoters', [PromoterController::class, 'index'])->middleware(['auth'])->name('promoters.index');
// store aggiungere nuovo promoter al db
Route::post('/promoters', [PromoterController::class, 'store'])->middleware(['auth'])->name('promoters.store');
// create nuovo promoter
Route::get('/promoters/create', [PromoterController::class, 'create'])->middleware(['auth'])->name('promoters.create');
// export dati filtrati
Route::get('/promoters/export', [PromoterController::class, 'export'])->middleware(['auth'])->name('promoters.export');
// show dettaglio singolo promoter
Route::get('/promoters/{id}', [PromoterController::class, 'show'])->middleware(['auth'])->name('promoters.show');
// edit, mostrerà il form per modificare un record specifico
Route::get('/promoters/{id}/edit', [PromoterController::class, 'edit'])->middleware(['auth'])->name('promoters.edit');
// update invia al db i dati modificati di un record già presente metodo o PUT o PATCH
Route::put('/promoters/{id}', [PromoterController::class, 'update'])->middleware(['auth'])->name('promoters.update');
// delete/suspended promoter
Route::patch('/promoters/{id}', [PromoterController::class, 'disable'])->middleware(['auth'])->name('promoters.disable');

require __DIR__.'/auth.php';
