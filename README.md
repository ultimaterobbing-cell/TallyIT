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

## Screenshots

<img width="1269" height="793" alt="SCrenshot 2" src="https://github.com/user-attachments/assets/dc91a138-8e52-4396-937f-47b755bd60a3" />

<img width="1358" height="819" alt="Screenshot 1" src="https://github.com/user-attachments/assets/df388bed-70c4-4d8e-895f-fd91572820da" />
