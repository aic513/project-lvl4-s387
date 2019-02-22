<?php

namespace Tests\Feature;

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
}
