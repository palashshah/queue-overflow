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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//User Routes
Route::Resource('/users', 'UserController');

Route::group(['prefix'=>'users'], function(){
	Route::get('/{user}/suspend', 'UserController@suspend')->name('users.suspend');
	Route::get('/{user}/activate', 'UserController@activate')->name('users.activate');
	Route::get('/{user}/makeadmin', 'UserController@makeAdmin')->name('users.makeadmin');
	Route::post('/{user}/reward', 'UserController@reward')->name('users.reward');
});


//Question Routes
Route::resource('/questions', 'QuestionController')->except('update', 'destroy');
Route::post('/questions/{question}/update', 'QuestionController@update')->name('questions.update');
Route::get('/questions/{question}/destroy', 'QuestionController@destroy')->name('questions.destroy');


//Answer Routes

Route::group(['prefix'=>'questions'], function(){
	Route::get('/{question}/upvote', 'QuestionController@upvote')->name('questions.upvote');
	Route::get('/{question}/downvote', 'QuestionController@downvote')->name('questions.downvote');
	Route::get('/{question}/cancelvote', 'QuestionController@cancelvote')->name('questions.cancelvote');

	Route::post('/{question}/answers', 'AnswerController@store')->name('answers.store');
	Route::get('/{question}/answers/{answer}/destroy', 'AnswerController@destroy')->name('answers.destroy');
	Route::post('/{question}/answers/{answer}/update', 'AnswerController@update')->name('answers.update');
	Route::get('/{question}/answers/{answer}/edit', 'AnswerController@edit')->name('answers.edit');

	Route::get('/{question}/answers/{answer}/upvote', 'AnswerController@upvote')->name('answers.upvote');
	Route::get('/{question}/answers/{answer}/downvote', 'AnswerController@downvote')->name('answers.downvote');
	Route::get('/{question}/answers/{answer}/cancelvote', 'AnswerController@cancelvote')->name('answers.cancelvote');

	//Comment Routes
	Route::resource('/{question}/answers/{answer}/comments', 'CommentController')->except('update','destroy');
	Route::get('/{question}/answers/{answer}/comments/{comment}/destroy', 'CommentController@destroy')->name('comments.destroy');
	Route::post('/{question}/answers/{answer}/comments/{comment}/update', 'CommentController@update')->name('comments.update');

	Route::get('/{question}/answers/{answer}/comments/{comment}/upvote', 'CommentController@upvote')->name('comments.upvote');
	Route::get('/{question}/answers/{answer}/comments/{comment}/downvote', 'CommentController@downvote')->name('comments.downvote');
	Route::get('/{question}/answers/{answer}/comments/{comment}/cancelvote', 'CommentController@cancelvote')->name('comments.cancelvote');

	Route::get('/{question}/answers/{answer}/accept', 'AnswerController@accept')->name('answers.accept');
});



//Tag Routes
Route::resource('/tags', 'TagController');


Route::get('/markAsRead', function(){
	if(auth()->check())
		auth()->user()->unreadNotifications->markAsRead();
})->name('markasread');


// Route::get('/questions', 'QuestionController@index')->name('questions.index');
// Route::get('/questions/{question}', 'QuestionController@show')->name('questions.show');
// Route::post('/questions', 'QuestionController@store')->name('questions.store');
// 	Route::put('/{user}/questions/{question}', 'QuestionController@update')->name('questions.update');
// 	Route::delete('/{user}/questions/{question}', 'QuestionController@destroy')->name('questions.destroy');