<?php

namespace App\Repositories;

use \Illuminate\Support\Collection;
use \Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function store(array $attrubutes): Collection;

    public function get(int $id): Collection;

    public function getAll(array $attrubutes): LengthAwarePaginator;

    public function update(int $id, array $attrubutes): Collection;

    public function delete(int $id): Collection;
}
