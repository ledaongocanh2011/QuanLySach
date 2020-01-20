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

Route::get('abc', function () {
    return view('book-manager');
});
//Route::get('registerr', 'AccountController@create');
Route::get('get', 'BookController@index');
Route::get('borrow/{id}', 'BookController@show')->name('borrow');
Route::get('getuser', 'BookUserController@getUser');
Route::get('addBook', 'BookController@addBook');

Auth::routes();
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(['middleware' => 'checkRoleAdmin'], function () {
        /** authors */
        Route::get('authors', 'AuthorController@index')->name('authors');
        Route::post('authors', 'AuthorController@addAuthor')->name('addAuthor');
        Route::get('authorList', 'AuthorController@authorList');
        Route::post('author/update', 'AuthorController@update');
        Route::delete('author/{id}', 'AuthorController@delete');
        /** books crud */
        Route::get('books', 'BookController@index');
        Route::post('books', 'BookController@addBook')->name('addBook');
        Route::post('updateBook', 'BookController@update');
        Route::delete('books/{id}', 'BookController@delete');
        /** restore */
        Route::get('restoreBook', 'BookController@restore')->name('restoreBook');
        Route::get('restoreBook/{id}', 'BookController@restoreById')->name('restoreById');
        Route::get('restoreAuthor', 'AuthorController@restore')->name('restoreAuthor');
        Route::get('restoreAuthor/{id}', 'AuthorController@restoreById')->name('restoreAuthorById');
        /** user */
        Route::get('users', 'UserController@index')->name('users');
        Route::get('userList', 'UserController@userList');
        Route::post('update', 'UserController@update');
        Route::delete('user/{id}', 'UserController@delete');
    });

    /** books user*/
    Route::get('getUthor', 'BookController@getAuthor')->name('books');
    Route::get('bookList', 'BookController@bookList');
    Route::get('ajaxBookList', 'BookController@ajaxBookList');
    Route::get('bookDetail/{id}', 'BookController@show')->name('bookDetail');
    Route::post('bookDetail/{id}', 'BookController@borrowBook')->name('borrow');
    Route::get('giveBookBack', 'BookController@giveBookBack')->name('giveBookBack');
    Route::get('payBook/{id}/{process_id}', 'BookController@payBook')->name('payBook');
});




//Route::get('borrow','BookController@create');




