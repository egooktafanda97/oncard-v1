<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Auth extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // $loginData = ['email' => 'sample@test.com', 'password' => 'sample123'];

        // $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
        //     ->assertStatus(200)
        //     ->assertJsonStructure([
        //         "user" => [
        //             'id',
        //             'name',
        //             'email',
        //             'email_verified_at',
        //             'created_at',
        //             'updated_at',
        //         ],
        //         "access_token",
        //         "message"
        //     ]);

        // $this->assertAuthenticated();
    }
}
