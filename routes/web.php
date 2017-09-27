<?php


Route::view('/', 'welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Lesson
Route::name('lessons.create')->get('lessons/{user}/create', 'LessonController@create');
Route::name('lessons.store')->post('lessons/{user}', 'LessonController@store');




#####################################################
// Rerdirects all nonexisting rutes to selected route
//Must be on the end of the page
Route::any('{query}', function(){
    return redirect('/');
})->where('query', '.*');
#####################################################