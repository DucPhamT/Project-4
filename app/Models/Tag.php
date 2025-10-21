<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [

        'content',
    ];
    public function users()
    { //1 tag chi thuoc ve 1 user
        return $this->belongsTo(User::class);
    }
    public function posts()
    { // n-n
        return $this->belongsToMany(Post::class);
    }
}
