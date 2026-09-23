<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_dashboard_displays_tasks(): void
    {
        Task::create(['task_name' => 'Plan the week', 'description' => 'Set priorities', 'status' => 'Pending']);

        $response = $this->get('/');

        $response->assertOk()->assertSee('Plan the week');
    }

    public function test_a_task_can_be_created_and_completed(): void
    {
        $this->post('/tasks', [
            'task_name' => 'Ship the project',
            'description' => 'Publish the repository',
            'status' => 'Pending',
            'due_date' => '2026-09-30',
        ])->assertRedirect('/tasks');

        $task = Task::firstOrFail();
        $this->patch("/tasks/{$task->id}/status")->assertRedirect();

        $this->assertDatabaseHas('tasks', ['task_name' => 'Ship the project', 'status' => 'Completed']);
    }

    public function test_a_task_can_be_updated_and_deleted(): void
    {
        $task = Task::create([
            'task_name' => 'Draft outline',
            'description' => 'Write the first version',
            'status' => 'Pending',
            'due_date' => '2026-09-30',
        ]);

        $this->put("/tasks/{$task->id}", [
            'task_name' => 'Finish outline',
            'description' => 'Review and submit the final version',
            'status' => 'Completed',
            'due_date' => '2026-10-01',
        ])->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'task_name' => 'Finish outline',
            'status' => 'Completed',
        ]);

        $this->delete("/tasks/{$task->id}")->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
