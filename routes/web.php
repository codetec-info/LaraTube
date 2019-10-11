<?php


use Laratube\Http\Controllers\UploadVideoController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('channels', 'ChannelController');


Route::middleware(['auth'])->group(function () {

    Route::post('channels/{channel}/videos', [UploadVideoController::class, 'store']);
    Route::get('channels/{channel}/videos', [UploadVideoController::class, 'index'])->name('channels.upload');

    Route::resource('channels/{channel}/subscriptions', 'SubscriptionController')->only([
        'store', 'destroy'
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs');
});
