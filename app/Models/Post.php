<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'user_id'];

    
    protected static function boot()
    {
        parent::boot();
        static::observe(PostObserver::class);
    }
}
