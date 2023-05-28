<?php

namespace App\Repositories;

use \Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface AdapterInterface
{
    public static function beCollection(Model $model): Collection;
}
