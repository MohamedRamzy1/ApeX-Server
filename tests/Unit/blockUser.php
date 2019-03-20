<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\User;
use App\block;

class blockUser extends TestCase
{

    use WithFaker;
    
    /**
     * Test a user block another user and testing alredy existing block
     *
     * @test 
     *
     * @return void
     */
    public function validBlock()
    {
        //make a new user, sign him up and get the token
        $username = $this->faker->userName;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password;
        
        $signUpResponse = $this->json(
            'POST', '/api/sign_up', compact('email', 'username', 'password')
        );
        $signUpResponse->assertStatus(200);

        $token = $signUpResponse->json('token');
        $blockerID = $signUpResponse->json('user')->id;

        //make the blocked user
        $blockedID = factory(User::class)->create()->id;

        $response = $this->json(
            'POST', 'api/block_user', compact('token', 'blockedID')
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('blocks', compact('blockerID', 'blockedID'));

        //test requseting the block again
        $response = $this->json(
            'POST', 'api/block_user', compact('token', 'blockedID')
        );

        $response->assertStatus(400)->assertSee(
            'The user is already blocked for the current user'
        );

        //delete the created users and block
        block::where(compact('blockerID', 'blockedID'))->delete();

        User::where('id', $blockedID)->orWhere('id', $blockedID)->delete();
    }

    /**
     * Test a block request with no token sent
     *
     * @test 
     *
     * @return void
     */
    public function noToken()
    {
        
        $blockedID = User::inRandomOrder()->firstOrFail()->id;

        $response = $this->json(
            'POST', 'api/block_user', compact('blockedID')
        );

        $response->assertStatus(400);

    }

    /**
     * Test a block request without blockedID 
     *
     * @test 
     *
     * @return void
     */
    public function noBlockedID()
    {
        //make a new user, sign him up and get the token
        $username = $this->faker->userName;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password;
        
        $signUpResponse = $this->json(
            'POST', '/api/sign_up', compact('email', 'username', 'password')
        );
        $signUpResponse->assertStatus(200);

        $token = $signUpResponse->json('token');
        $blockerID = $signUpResponse->json('user')->id;


        $response = $this->json(
            'POST', 'api/block_user', compact('token')
        );

        $response->assertStatus(400)->assertSee('blockedID');

        //delete the created users
        User::where('id', $blockerID)->delete();
    }

    /**
     * Test a block request with invalid blockedID 
     *
     * @test 
     *
     * @return void
     */
    public function invalidBlockedID()
    {
        //make a new user, sign him up and get the token
        $username = $this->faker->userName;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password;
        
        $signUpResponse = $this->json(
            'POST', '/api/sign_up', compact('email', 'username', 'password')
        );
        $signUpResponse->assertStatus(200);

        $token = $signUpResponse->json('token');
        $blockerID = $signUpResponse->json('user')->id;

        $blockedID = '-1';

        $response = $this->json(
            'POST', 'api/block_user', compact('token', 'blockedID')
        );

        $response->assertStatus(400)->assertSee('blockedID');

        //delete the created users
        User::where('id', $blockerID)->delete();
    }

    /**
     * Test a user block himself
     *
     * @test 
     * 
     * @return void
     */
    public function selfBlock()
    {
        //make a new user, sign him up and get the token
        $username = $this->faker->userName;
        $email = $this->faker->safeEmail;
        $password = $this->faker->password;
        
        $signUpResponse = $this->json(
            'POST', '/api/sign_up', compact('email', 'username', 'password')
        );
        $signUpResponse->assertStatus(200);

        $token = $signUpResponse->json('token');
        $blockerID = $signUpResponse->json('user')->id;


        $response = $this->json(
            'POST', 'api/block_user', compact('token', 'blockerID')
        );

        $response->assertStatus(400)->assertSee("The user can't block himself");

        User::where('id', $blockerID)->delete();
    }
}