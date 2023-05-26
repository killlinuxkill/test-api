<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PostTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['post_id', 'language_id', 'title','description', 'content'];

    public function language()
    {
        return $this->belongsTo(\App\Models\Language::class, 'language_id');
    }

    public function scopeByLanguage(Builder $query, Language $language): void
    {
        $query->where('language_id', $language->id);
    }
}
