<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


Route::get('students/{hash}', 'Events\EventsController@showStudent')->where('hash', '[0-9a-zA-Z-]+')->name('student');
Route::post('/uploadFile/{id}', 'Events\EventsController@addCV')->where('id', '[0-9]+')->name('events.upload_student_cv');

Route::middleware(['auth'])->group(function (){

    Route::get('/help', 'Help\HelpController@index')->name('help');

    Route::namespace('Events')->group(function (){
        Route::prefix('events')->group(function (){
            Route::get('/detail/{id}', 'EventsController@detail')->where('id', '[0-9]+')->name('events.detail');

            Route::get('/getFile/{id}/{name}', 'EventsController@getCV')->where('id', '[0-9]+')->name('events.get_student_cv');

            Route::get('/{filterBy?}/{filter?}', 'EventsController@index')->where('filterBy', '[a-zA-Z]+')->where('filter', '[a-zA-Z0-9]+')->name("events.list");
            Route::post('/add', 'EventsController@add')->name('events.addEvent');
            Route::post('/addStudent/{id}', 'EventsController@addStudent')->where('id', '[0-9]+')->name('events.addStudent');
            Route::post('/addComment', 'EventsController@addComment')->name('events.addComment');
            Route::post('/addStudentComment', 'EventsController@addStudentComment')->name('events.addStudentComment');
            Route::post('/editEvent', 'EventsController@editEvent')->name('events.editEvent');

        });
    });
    Route::namespace('Schools')->group(function (){
        Route::prefix('schools')->group(function (){
            Route::get('/{id?}', 'SchoolsController@index')->where('id', '[0-9]+')->name("school.list");
            //Route::get('/detail/{id}', 'SchoolsController@index')->where('id', '[0-9]+')->name('school.show');



        });
    });
    Route::namespace('Schools')->group(function (){
        Route::prefix('schools')->group(function (){
            Route::get('/detail/{id}', 'SchoolsController@detail')->where('id', '[0-9]+')->name("school.detail");
            Route::post('/addComment', 'SchoolsController@addComment')->name('school.addComment');
            Route::post('/addContact', 'SchoolsController@addContact')->name('school.addContact');
            Route::post('/addSchool', 'SchoolsController@addSchool')->name('school.addSchool');
            Route::post('/editSchool', 'SchoolsController@editSchool')->name('school.editSchool');

        });
    });
    Route::namespace('Account')->group(function (){
        Route::prefix('account')->group(function (){



        });
    });
});
