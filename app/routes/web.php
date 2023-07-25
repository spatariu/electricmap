<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear', function () {
    $stream = fopen("php://output", "w");
    $output = new Symfony\Component\Console\Output\StreamOutput($stream);
    \Illuminate\Support\Facades\Artisan::call('cache:clear', [], $output);
    echo '<br>';
    \Illuminate\Support\Facades\Artisan::call('route:cache', [], $output);
    echo '<br>';
    \Illuminate\Support\Facades\Artisan::call('view:clear', [], $output);
    echo '<br>';
    \Illuminate\Support\Facades\Artisan::call('config:cache', [], $output);
});