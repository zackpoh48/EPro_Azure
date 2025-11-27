<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| V1 Web Routes
|--------------------------------------------------------------------------
|
|
|
*/

// Route::get('/', function () {
//     return redirect('/login');
// });

// Route::get('/login', function () {
//     return view('layouts.scripts');
// });

// Route::get('/tender-details/{any?}', function () {
//     return view('layouts.scripts');
// });


// Route::get('/register/{any?}', function () {
//     return view('layouts.scripts');
// })->where('any', '.*');

// Route::get('/reset-password/{any?}', function () {
//     return view('layouts.scripts');
// });

// Route::get('/{any?}', function () {
//     return view('layouts.scripts');
// });



/*
|--------------------------------------------------------------------------
| V2 Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{any?}/{child?}/{order?}', function () {
    return view('app');
});
