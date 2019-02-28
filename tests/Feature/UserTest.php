<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
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

    public function testGetUserLoginForm()
    {
        $response = $this->get(route('login'));
        $response->assertOk();
    }

    public function testUserLogin()
    {
        $response = $this->post(route('login'), array_merge(
            $this->userData,
            ['password' => $this->password]
        ));
        $response->assertRedirect(route('home'));
    }

    public function testUserLogout()
    {
        $response = $this->actingAs($this->user)->post('logout');
        $response->assertRedirect('/');
    }

    public function testGetUserRegistrationForm()
    {
        $response = $this->get(route('register'));
        $response->assertOk();
    }

    public function testUserIndex()
    {
        $url = route('users.index');
        $response = $this->actingAs($this->user)->get($url);
        $response->assertStatus(200);
    }

    public function testUserRegistration()
    {
        $userData = [
            'name' => 'Some User',
            'email' => 'some@mail.ru',
            'password' => '123456abcdef',
            'password_confirmation' => '123456abcdef',
        ];
        $response = $this->post(route('register'), $userData);
        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
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

    public function testChangePassword()
    {
        $user = factory(User::class)->create([
            'password' => 'SomePassword'
        ]);
        $url = route('user.changePassword');
        $getResponse = $this->actingAs($user)->get($url);
        $getResponse->assertStatus(200);
        $newPassword = 'newPassword';
        $postUrl = route('user.storePassword');
        $postResponse = $this->actingAs($user)->patch($postUrl, [
            'current-password' => 'SomePassword',
            'new-password' => $newPassword,
            'new-password_confirmation' => $newPassword
        ]);
        $postResponse->assertStatus(302);
        $this->assertFalse(Hash::check($newPassword, $user->password));
    }

    public function testUserDelete()
    {
        $user = factory(\App\User::class)->create();
        $url = route('users.destroy', ['id' => $user->id]);
        $response = $this->actingAs($user)->delete($url);
        $response->assertStatus(302);
        $this->assertTrue($user->trashed());
    }
}
