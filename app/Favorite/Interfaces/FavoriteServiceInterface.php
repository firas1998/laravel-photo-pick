<?php

namespace App\Favorite\Interfaces;

use App\Favorite\Models\Favorite;
use Illuminate\Database\Eloquent\Collection;

interface FavoriteServiceInterface
{
    public function getFavoriteById($id): Favorite;

    public function addFavorite(array $attributes);

    public function getMostFavouritedPhotosInWeek(): Collection;

    public function unFavorite($photoId);

    public function isPhotoFavorited($photoId): array;
}
