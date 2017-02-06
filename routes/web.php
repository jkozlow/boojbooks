<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::match(['get', 'post'], '/', 'BooksController@start')->name('home');

Route::match(['get', 'post'], 'about', 'BooksController@about')->name('about');

Route::match(['get', 'post'], 'search/{query?}', 'BooksController@search')->name('search');

Route::match(['get', 'post'], 'searchlocal/{query?}', 'BooksController@searchlocal')->name('searchlocal');

Route::match(['get', 'post'], "books/{book_id?}",  'BooksController@showbook')->name('book');

Route::match(['get', 'post'], "booksinlist/{booklist_id?}",  'BooksController@booksinlist')->name('booksinlist');

Route::match(['get', 'post'], "booklists/{booklist_id?}",  'BooksController@booklists')->name('booklists');

Route::match(['get', 'post'], "bookplanner",  'BooksController@bookplanner')->name('bookplanner');