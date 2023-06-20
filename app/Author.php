<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Author extends Authenticatable
{
    //
    protected $hidden = ['password', 'updated_at', 'remember_token'];

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id', 'id');
    }
}
