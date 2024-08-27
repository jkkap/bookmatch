<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/chat/{user}', [ChatController::class, 'openChat']);
Route::post('/chat', [ChatController::class, 'sendMessage']);

Route::post('/friend-request/send/{id}', [FriendshipController::class, 'sendRequest']);
Route::post('/friend-request/accept/{id}', [FriendshipController::class, 'acceptRequest']);
Route::post('/friend-request/reject/{id}', [FriendshipController::class, 'rejectRequest']);

require __DIR__.'/auth.php';
