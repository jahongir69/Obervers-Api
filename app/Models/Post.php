<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([PostObserver::class])]

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'user_id'];

    
}
