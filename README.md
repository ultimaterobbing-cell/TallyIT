# TallyIT Task Manager

Project Code: WST21-PM-2026-SF  
Student Name: Inocencio Jeff Carl  
Course & Year: BSIT - 2  
Database Used: Supabase PostgreSQL

## Features

- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status

## Status Route

This Laravel web route toggles a task between Pending and Completed:

```php
Route::patch('/tasks/{task}/status', [TaskController::class, 'toggleStatus'])
	->name('tasks.status');
```