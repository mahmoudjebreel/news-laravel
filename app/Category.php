<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $appends = ['visible_articles_count'];

    public function getVisibleArticlesCountAttribute()
    {
        return $this->articles()->where('visibility_status', 'Visible')->count();
    }

    public function articles()
    {
        return $this->hasMany(Article::class,'category_id','id');
    }
}
