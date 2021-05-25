<?php

namespace Database\Factories\Favorite\Models;

use App\Favorite\Models\Favorite;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class FavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Favorite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lastMonday = date('Y-m-d', strtotime('last monday'));
        $lastWeek = date('Y-m-d', strtotime('last week'));
        $dateArray = [$lastMonday, $lastWeek];
        $user = User::inRandomOrder()->first();
        if($user){
            $userId = $user['id'];
        } else {
            $userId = 1;
        }
        return [
            'user_id' => $userId,
            'photo_id' => $this->faker->numberBetween(1, 100),
            'created_at' => $this->faker->randomElement($dateArray)
        ];
    }
}
