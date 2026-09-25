<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = request('status', 'all');
        $tasks = Task::query()
            ->when(in_array($filter, ['Pending', 'Completed'], true), fn ($query) => $query->where('status', $filter))
            ->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")
            ->orderBy('due_date')
            ->latest()
            ->get();

        return view('tasks.index', [
            'tasks' => $tasks,
            'filter' => $filter,
            'stats' => [
                'total' => Task::count(),
                'pending' => Task::where('status', 'Pending')->count(),
                'completed' => Task::where('status', 'Completed')->count(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['completed_at'] = $data['status'] === 'Completed' ? now() : null;

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task added to your list.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $this->validated($request);

        if ($data['status'] === 'Completed' && $task->status !== 'Completed') {
            $data['completed_at'] = now();
        } elseif ($data['status'] === 'Pending') {
            $data['completed_at'] = null;
        }

        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }

    public function toggleStatus(Task $task)
    {
        $status = $task->status === 'Completed' ? 'Pending' : 'Completed';
        $task->update([
            'status' => $status,
            'completed_at' => $status === 'Completed' ? now() : null,
        ]);

        return redirect()->back()->with('success', $task->status === 'Completed' ? 'Task completed.' : 'Task marked as pending.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'task_name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', Rule::in(['Pending', 'Completed'])],
            'due_date' => ['nullable', 'date'],
        ]);
    }
}
