<?php

namespace App\Repositories;

use App\Models\Language;
use Closure;
use \Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements RepositoryInterface, ValidateInterface, AdapterInterface
{
    protected $language;
    protected $per_page = 10;

    /**
     * Init current language by prefix
     */
    public function __construct(string $locale)
    {
        $this->initLanguage($locale);
    }

    /**
     * Init Language
     */
    public function initLanguage(string $locale = null): BaseRepository
    {
        if (!is_null($locale)) {
            $language = Language::where('locale', $locale)->first();
            if (!empty($language)) {
                $this->language = $language;
            }
        }
        return $this;
    }

    public function setLanguage(Language $language): BaseRepository
    {
        $this->language = $language;
        return $this;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function setPerPage(int $per_page): BaseRepository
    {
        return $this->per_page = $per_page;
        return $this;
    }

    public function getPerPage(): int
    {
        return $this->per_page;
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

    public function beCollection(Model $model): Collection
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
