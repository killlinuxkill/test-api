<?php

namespace App\Repositories;

interface ValidateInterface
{
    public function checkIsAvailable(int $id): bool;

    public function checkDuplicate(array $attributes): bool;
}
