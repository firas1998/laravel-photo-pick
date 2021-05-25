<?php

namespace App\Favorite\Models;

use App\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'photo_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
