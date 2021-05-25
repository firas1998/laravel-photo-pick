<?php

namespace Tests\e2e;

use App\User\Models\User;
use Tests\TestCase;

class ApiTestCase extends TestCase {

    public function getAuthHeader($user = null) {
        $user = $user ? $user : User::factory()->create();
        $credentials = [
            'email' => $user['email'],
            'password' => 'password'
        ];
        $token = auth()->attempt($credentials);
        return 'Bearer ' . $token;
    }
}