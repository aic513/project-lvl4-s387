<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserIndex()
    {
        $user = factory(User::class)->make();
        $url = route('users.index');
        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(200);
    }

    public function testUserInfo()
    {
        $user = factory(User::class)->create();
        $url1 = route('users.show', ['id' => $user->id]);
        $getResponse = $this->actingAs($user)->get($url1);
        $getResponse->assertStatus(200);
        $patchUrl = route('users.update', ['id' => $user->id]);
        $patchResponse = $this->actingAs($user)->patch($patchUrl, ['name' => 'newName', 'email' => $user->email]);
        $patchResponse->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'name' => 'newName'
        ]);
    }

    public function testGetUserLoginForm()
    {
        $response = $this->get(route('login'));
        $response->assertOk();
    }


    public function testGetUserRegistrationForm()
    {
        $response = $this->get(route('register'));
        $response->assertOk();
    }

    public function testUserDelete()
    {
        $user = factory(\App\User::class)->create();
        $url = route('users.destroy', ['id' => $user->id]);
        $response = $this->actingAs($user)->delete($url);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', $user->toArray());
    }

}
