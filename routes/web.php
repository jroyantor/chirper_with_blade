<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;


Route::get('/', [SearchController::class,'show']);

Route::get('/search/{name}',[SearchController::class,'search_by_type']);

Route::get('/search', function(){
    return view('search');
})->middleware('auth');


Route::post('/search',[SearchController::class,'store'])
->middleware('auth')->name('search');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';
