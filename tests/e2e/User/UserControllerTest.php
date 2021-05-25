<?php

use App\Favorite\Models\Favorite;
use App\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\e2e\ApiTestCase;

class UserControllerTest extends ApiTestCase
{
    use RefreshDatabase;


    public function testCreateUser()
    {
        $resp = $this->post(
            'api/user/create',
            [
                'username' => 'test',
                'email' => 'test@example.com',
                'password' => 'password'
            ]
        );

        $resp->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    public function testMe()
    {
        $resp = $this->get(
            'api/user/me',
            [
                'Authorization' => $this->getAuthHeader()
            ]
        );

        $resp->assertStatus(200);
    }

    public function testLogin()
    {
        $user = User::factory()->create();
        $resp = $this->post(
            'api/user/login',
            [
                'email' => $user['email'],
                'password' => 'password'
            ]
        );

        $resp->assertStatus(200);
    }

    public function testGetUsersWithMostFavoritesInWeek()
    {
        User::factory()->count(5)->create();
        Favorite::factory()->count(10)->create();
        $resp = $this->get(
            'api/users/favorites'
        );
        $resp->assertStatus(200);
        dump($resp->json());
    }
}
