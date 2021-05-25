<?php

namespace Tests\Unit\User\Services;

use App\User\Models\User;
use App\User\Repositories\UserRepository;
use App\User\Services\UserService;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class UserServiceTest extends TestCase
{

    public function testGetUserById()
    {
        $user = User::factory()->make();
        $userRepoMock = $this->mock(UserRepository::class);
        $userRepoMock->shouldReceive('find')->withArgs([1])->andReturn($user);
        $userService = new UserService($userRepoMock);
        $res = $userService->getUserById(1);
        $this->assertEquals($user['email'], $res['email']);
    }

    public function testGetUserByIdFail()
    {
        $userRepoMock = $this->mock(UserRepository::class);
        $userRepoMock->shouldReceive('find')->withArgs([1])->andReturn(null);
        $userService = new UserService($userRepoMock);
        $this->expectException(HttpException::class);
        $res = $userService->getUserById(1);
    }

    public function testCreateUser()
    {
        $user = User::factory()->make();
        $userRepoMock = $this->mock(UserRepository::class);
        $userRepoMock->shouldReceive('create')->andReturn($user);
        $userService = new UserService($userRepoMock);
        $res = $userService->createUser(
            [
                'username' => $user['username'],
                'email' => $user['email'],
                'password' => $user['password']
            ]
        );
        $this->assertEquals($user['email'], $res['email']);
    }

    public function testGetUsersWithMostFavoritesInWeek()
    {
        $users = User::factory()->count(10)->make();
        $userRepoMock = $this->mock(UserRepository::class);
        $userRepoMock->shouldReceive('getUsersWithMostFavoritesInWeek')->andReturn($users);
        $userService = new UserService($userRepoMock);
        $res = $userService->getUsersWithMostFavoritesInWeek();
        $this->assertEquals(count($users), count($res));
    }
}
