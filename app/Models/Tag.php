<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'language_id'];

    public function scopeByLanguage(Builder $query, Language $language): void
    {
        $query->where('language_id', $language->id);
    }

    public function posts()
    {
        return $this->belongsToMany(\App\Models\Post::class, 'post_tags', 'tag_id', 'post_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
