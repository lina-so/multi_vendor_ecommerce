<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Front\Cart\CartController;
use App\Http\Controllers\Dashboard\Product\ProductController;

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
    return view('auth.register-as');
})->name('register-as');

// Auth::routes(['verify' => true]);

// Route::get('user/profile',[ProfileController::class,'index'])->middleware(['auth','verified']);
Route::get('user/profile',[ProfileController::class,'index'])->middleware(['auth:web','verified']);

Route::resource('cart', CartController::class)->except(['destroy']);
Route::delete('/cart/remove/{id}',  [CartController::class,'destroy'])->name('cart.remove');


Route::get('product-details/{id}', [ProductController::class,'show'])->name('product-details');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// في ملف الطرق (routes/web.php)
// Route::get('/key', function () {
//     Artisan::call('key:generate');
//     return "Encryption key generated successfully!";
// });

// في ملف الطرق (routes/web.php)
// Route::get('/update_database', function () {
//     Artisan::call('migrate', ['--force' => true]);
//     return "Database updated successfully!";
// });
