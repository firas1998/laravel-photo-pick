<?php

namespace Tests\Unit\Favorite\Services;

use App\Favorite\Models\Favorite;
use App\Favorite\Repositories\FavoriteRepository;
use App\Favorite\Services\FavoriteService;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class FavoriteServiceTest extends TestCase
{

    public function testGetFavoriteById()
    {
        $favorite = Favorite::factory()->make(['user_id' => 1]);
        $favoriteRepoMock = $this->mock(FavoriteRepository::class);
        $favoriteRepoMock->shouldReceive('find')->withArgs([$favorite['id']])->andReturn($favorite);
        $favoriteService = new FavoriteService($favoriteRepoMock);
        $res = $favoriteService->getFavoriteById($favorite['id']);
        $this->assertEquals($favorite['id'], $res['id']);
    }

    public function testGetFavoriteByIdFail()
    {
        $this->expectException(HttpException::class);
        $favoriteRepoMock = $this->mock(FavoriteRepository::class);
        $favoriteRepoMock->shouldReceive('find')->withArgs([1])->andReturn(null);
        $favoriteService = new FavoriteService($favoriteRepoMock);
        $res = $favoriteService->getFavoriteById(1);
    }
}
