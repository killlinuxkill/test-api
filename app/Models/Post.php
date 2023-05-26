<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Language;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function translations()
    {
        return $this->hasMany(\App\Models\PostTranslation::class, 'post_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(\App\Models\Tag::class, 'post_tags', 'post_id', 'tag_id');
    }
}
