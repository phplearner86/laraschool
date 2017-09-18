<?php


Route::get('/', function () {
    return view('welcome');
});



// Rerdirects all nonexisting rutes to selected route
//Must be on the end of the page
Route::any('{query}', function(){
    return redirect('/');
})->where('query', '.*');
