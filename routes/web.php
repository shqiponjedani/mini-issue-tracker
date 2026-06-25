<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return redirect()->route('projects.index');
});

Route::resource('projects',ProjectController::class);
Route::get('projects/{project}/delete', [ProjectController::class, 'confirmDelete'])->name('projects.delete');
Route::get('issues/{issue}/comments',[CommentController::class, 'index'])->name('issues.comments.index');
Route::post('issues/{issue}/comments',[CommentController::class,'store'])->name('issues.comments.store');
Route::resource('issues',IssueController::class);
Route::post('issues/{issue}/toggle-tag', [IssueController::class, 'toggleTag'])->name('issues.toggle-tag');


Route::post('/issues/{issue}/toggle-user', [IssueController::class, 'toggleUser']);
Route::resource('tags', TagController::class)->only(['index','store']);

