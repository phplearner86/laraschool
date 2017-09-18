<?php


Route::view('/', 'welcome');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Rerdirects all nonexisting rutes to selected route
//Must be on the end of the page
Route::any('{query}', function(){
    return redirect('/');
})->where('query', '.*');
