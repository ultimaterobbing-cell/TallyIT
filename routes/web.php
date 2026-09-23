<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TaskController::class, 'index']);
Route::resource('tasks', TaskController::class)->except(['show']);
Route::patch('/tasks/{task}/status', [TaskController::class, 'toggleStatus'])->name('tasks.status');
