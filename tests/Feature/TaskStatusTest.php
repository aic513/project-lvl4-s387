<?php

namespace Tests\Feature;

use App\TaskStatus;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Hash;
use Tests\CreatesApplication;

class TaskStatusTest extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $user;

    protected $userData;

    protected $password;

    public function setUp()
    {
        parent::setUp();
        $this->password = 'password';
        $this->userData = [
            'name' => 'Vasya Pupkin',
            'email' => 'mail@mail.ru',
            'password' => Hash::make($this->password),
        ];
        $this->user = factory(User::class)->create($this->userData);
    }

    public function testIndexTaskStatus()
    {
        $url = route('taskStatus.index');
        $response = $this->actingAs($this->user)->get($url);
        $response->assertStatus(200);
    }

    public function testUpdateTaskStatus()
    {
        $status = factory(TaskStatus::class)->create(['name' => 'notEditedStatus']);
        $url = route('taskStatus.update', ['id' => $status->id]);
        $response = $this->actingAs($this->user)->patch($url, ['name' => 'editedStatus']);
        $response->assertStatus(302);
        $this->assertDatabaseHas('task_statuses', ['name' => 'editedStatus']);
    }

    public function testDestroy()
    {
        $status = factory(TaskStatus::class)->create(['name' => 'example']);
        $url = route('taskStatus.destroy', ['id' => $status->id]);
        $response = $this->actingAs($this->user)->delete($url);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('task_statuses', $status->toArray());
    }
}
