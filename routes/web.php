<?php


Route::view('/', 'welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Lesson
Route::name('lessons.create')->get('lessons/{user}/create', 'LessonController@create');
Route::name('lessons.store')->post('lessons/{user}', 'LessonController@store');
Route::name('lessons.edit')->get('lessons/{user}/{lesson}/edit', 'LessonController@edit');
Route::name('lessons.update')->put('lessons/{user}/{lesson}', 'LessonController@update');

//  Event
Route::name('events.index')->get('calendar/{user}', 'EventController@index');




#####################################################
// Rerdirects all nonexisting rutes to selected route
//Must be on the end of the page
Route::any('{query}', function(){
    return redirect('/');
})->where('query', '.*');
#####################################################