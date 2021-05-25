<?php

use App\Favorite\Models\Favorite;
use App\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\e2e\ApiTestCase;

class FavoriteControllerTest extends ApiTestCase
{
    use RefreshDatabase;


    public function testAddFavorite()
    {
        $resp = $this->post(
            'api/favorite/add',
            [
                'photo_id' => 1
            ],
            [
                'Authorization' => $this->getAuthHeader()
            ]
        );
        $resp->assertStatus(200);
        $this->assertDatabaseHas('favorites', [
            'photo_id' => 1
        ]);
    }

    public function testUnfavorite()
    {
        $user = User::factory()->create();
        $favorite = Favorite::factory()->create();
        $resp = $this->post(
            'api/favorite/remove',
            [
                'photo_id' => $favorite['photo_id']
            ],
            [
                'Authorization' => $this->getAuthHeader($user)
            ]
        );
        $resp->assertStatus(200);
        $this->assertDatabaseMissing('favorites', [
            'photo_id' => $favorite['photo_id']
        ]);
    }

    public function testIsPhotoFavorited()
    {
        $user = User::factory()->create();
        $favorite = Favorite::factory()->create(['user_id' => $user['id']]);
        $resp = $this->get(
            'api/favorite/' . $favorite['photo_id'],
            [
                'Authorization' => $this->getAuthHeader($user)
            ]
        );
        $resp->assertStatus(200);
        $this->assertTrue($resp->json()['favorited']);
    }

    public function testIsPhotoFavoritedFalse()
    {
        $user = User::factory()->create();
        $resp = $this->get(
            'api/favorite/1',
            [
                'Authorization' => $this->getAuthHeader($user)
            ]
        );
        $resp->assertStatus(200);
        $this->assertFalse($resp->json()['favorited']);
    }

    public function testGetMostFavoritedPhotosInWeek()
    {
        User::factory()->count(5)->create();
        Favorite::factory()->count(10)->create();
        $resp = $this->get(
            'api/favorite'
        );
        $resp->assertStatus(200);
    }
}
