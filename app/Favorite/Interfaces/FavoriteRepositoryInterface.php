<?php

namespace App\Favorite\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface FavoriteRepositoryInterface
{
    public function getMostFavouritedPhotosInWeek(): Collection; 
    public function removeByPhotoIdAndUserId($photoId, $userId);
    public function isPhotoFavorited($photoId, $userId): bool;
}
