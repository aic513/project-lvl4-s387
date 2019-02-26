<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Tests\CreatesApplication;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->make();
        $url = route('task.index');
        $response = $this->actingAs($user)->get($url);
        $response->assertOk();
    }

    public function testCreate()
    {
        $user = factory(User::class)->make();
        $url = route('task.create');
        $response = $this->actingAs($user)->get($url);
        $response->assertOk();
    }

    public function testEdit()
    {
        $user = factory(User::class)->make();
        $tasks = factory(Task::class, 5)->create();
        $url = route('task.edit', ['id' => $tasks->first()]);
        $response = $this->actingAs($user)->get($url);
        $response->assertOk();
    }

    public function testStore()
    {
        $user = factory(User::class)->create();
        $url = route('task.store');
        $response = $this->actingAs($user)->post($url, [
            'name' => 'newTask',
            'status_id' => 1,
            'creator_id' => $user->first()->id,
            'assigned_to_id' => $user->id
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', ['name' => 'newTask']);
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $tasks = factory(Task::class, 10)->create();
        $task = $tasks->first();
        $url = route('task.update', $task->id);
        $response = $this->actingAs($user)->patch($url, [
            'name' => 'new task',
            'description' => 'updated',
            'assigned_to_id' => $task->assignedTo->id,
            'status_id' => $task->status->id
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', [
            'name' => 'new task',
            'description' => 'updated'
        ]);
    }

    public function testDestroy()
    {
        $user = factory(User::class)->make();
        factory(Task::class, 3)->create();
        $task = Task::first();
        $url = route('task.destroy', ['id' => $task->id]);
        $response = $this->actingAs($user)->delete($url);
        $response->assertStatus(302);
        $this->assertCount(2, Task::all());
    }
}
