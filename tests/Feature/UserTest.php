<?php
namespace Tests\Feature;
use Tests\TestCase;
class UserTest extends TestCase
{

    public function testUserIndex():void
    {
        $user = factory(\App\User::class)->make();
        $response = $this->actingAs($user)->get('/users');
        $response->assertStatus(200);
    }


    public function testUserDelete():void
    {
        $user = factory(\App\User::class)->make();
        $this->actingAs($user)->delete('/user/show');
        $this->assertDatabaseMissing('users', $user->toArray());
    }
}
