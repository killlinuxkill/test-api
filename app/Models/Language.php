<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['locale', 'prefix'];

    public $timestamps = false;

    public function tags()
    {
        return $this->hasMany(Tag::class, 'language_id', 'id');
    }

    public function postTranslations()
    {
        return $this->hasMany(PostTranslation::class, 'language_id', 'id');
    }
}
