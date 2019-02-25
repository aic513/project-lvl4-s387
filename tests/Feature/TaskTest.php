<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Tests\CreatesApplication;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(\App\User::class)->make();
        factory(Task::class, 3)->make();
        $url = route('task.index');
        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $user = factory(User::class)->make();
        $url = route('task.create');
        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(200);
    }
}
