<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    public function test_create_user(): void
    {


        $response = $this->postJson('/api/createUser', [
            'name' => 'ali test',
            'date_of_birth' => '1996-06-07',
            'email' => 'ali@qadomy.com',
            'phone_number' => '1234567890',
        ]);

        $response->assertStatus(200);
    }
    public function test_get_users(): void
    {
        $response = $this->getJson('/api/users');
        $response->assertStatus(200);
    }
    public function test_get_userId(): void
    {
        $user=User::where('email','ali@qadomy.com')->first();
        $id=$user->id;
        $response = $this->getJson('/api/user/'.$id);
        $response->assertStatus(200);
    }
}
