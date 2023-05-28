<?php

namespace App\Repositories;

use App\Models\Language;
use Closure;
use \Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements RepositoryInterface, ValidateInterface, AdapterInterface
{
    protected $per_page = 10;

    protected $languages = [];

    public function setPerPage(int $per_page): BaseRepository
    {
        return $this->per_page = $per_page;
        return $this;
    }

    public function getPerPage(): int
    {
        return $this->per_page;
    }

    public function getLanguages()
    {
        if (!empty($this->languages)) {
            return $this->languages;
        }

        foreach(Language::get() as $item) {
            $this->languages[$item->locale] = $item;
        }

        if (empty($this->languages)) {
            throw new \Exception('Language list cannot be empty.');
        }

        return $this->languages;
    }

    public function getLanguage($locale)
    {
        return $this->getLanguages()[$locale];
    }

    /**
     * Here, becouse it have access for current language
     */
    public function scopeByCurrentLanguage(): Closure
    {
        $language = $this->getLanguage();
        return function($query) use ($language){
            $query->byLanguage($language);
        };
    }

    // All below is fake so must be implemented in children
    public function store(array $attrubutes): Collection
    {
        return collect([]);
    }

    public function get(int $id): Collection
    {
        return collect([]);
    }

    public function getAll(array $attrubutes): LengthAwarePaginator
    {
        return collect([]);
    }

    public function update(int $id, array $attrubutes): Collection
    {
        return collect([]);
    }

    public function delete(int $id): Collection
    {
        return collect([]);
    }

    public static function beCollection(Model $model): Collection
    {
        return collect([]);
    }

    public function checkIsAvailable(int $id): bool
    {
        return true;
    }

    public function checkDuplicate(array $attributes): bool
    {
        return false;
    }
}
