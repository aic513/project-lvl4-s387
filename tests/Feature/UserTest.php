<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

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

}
