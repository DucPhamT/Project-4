<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'thumbnail',
    ];
    public function user() //1 post chi thuoc ve 1 user
    {
        return $this->belongsTo(User::class);
    }
    public function categories() // n-n
    {
        return $this->belongsToMany(Category::class);
    }
    public function comments()//1 post co n comment
    {
        return $this->hasMany(Comment::class);
    }


}
