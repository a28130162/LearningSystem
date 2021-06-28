<?php

use App\Http\Controllers\RedirectController;
use App\Http\Livewire\Classes;
use App\Http\Livewire\CommentPaper;
use App\Http\Livewire\CourseEdit;
use App\Http\Livewire\CourseList;
use App\Http\Livewire\CourseQuestion;
use App\Http\Livewire\Department;
use App\Http\Livewire\RecordContent;
use App\Http\Livewire\RecordList;
use App\Http\Livewire\Management;
use App\Http\Livewire\Question;
use App\Http\Livewire\Quiz;
use App\Http\Livewire\Subject;
use App\Http\Livewire\User;
use Illuminate\Support\Facades\Route;

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
    return view('index');
});
Route::get('/homepage', RedirectController::class)->name('homepage');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    Route::get('/course', CourseList::class)->name('course');
    Route::get('/record', RecordList::class)->name('record');
    Route::get('/record/{record}', RecordContent::class)
        ->where('record', '[0-9]+')->name('record-content');

    Route::group(['middleware' => ['role:student']], function () {
        Route::get('/course/{course}', CourseQuestion::class)
            ->where('course', '[0-9]+')->name('course-question');
        Route::get('/course/{course}/{question}', Quiz::class)
            ->where('course', '[0-9]+')->where('question', '[0-9]+')->name('quiz');
    });

    Route::group(['middleware' => ['role:teacher']], function () {
        Route::get('/question', Question::class)->name('question');
        Route::get('/comment_paper', CommentPaper::class)->name('comment_paper');
        Route::get('/course/{course}/edit', CourseEdit::class)
            ->where('course', '[0-9]+')->name('course-edit');
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/management', Management::class)->name('management');
        Route::get('/department', Department::class)->name('department');
        Route::get('/class', Classes::class)->name('classes');
        Route::get('/user', User::class)->name('user');
        Route::get('/subject', Subject::class)->name('subject');
    });
});
