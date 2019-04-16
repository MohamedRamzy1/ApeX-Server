<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class validgetprefs extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $loginResponse = $this->json(
            'POST',
            '/api/sign_in',
            [
            'username' => 'Monda Talaat',
            'password' => 'monda21'
            ]
        );
        $token = $loginResponse->json('token');
        $prefsResponse = $this->json(
            'GET',
            '/api/prefs',
            [
            'token' => $token
            ]
        );
        $prefsResponse->assertStatus(200);
    }
}