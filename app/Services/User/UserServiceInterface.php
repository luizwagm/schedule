<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function get(): User;
    public function getLatestUser(): User;
    public function delete(int $id): void;
}
