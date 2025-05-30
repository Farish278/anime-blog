<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'published_at' => 'date',
    ];
}
