<?php

namespace App\Repositories;

use \Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface AdapterInterface
{
    public function beCollection(Model $model): Collection;
}
