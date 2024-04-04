<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    /**
     * Get user function
     *
     * @param integer $id
     * @param string $document
     * @return User
     */
    public function get(int $id, string $document = ''): User;

    /**
     * Get all notifications function
     *
     * @param integer $id
     * @return Collection
     */
    public function notifications(int $id): Collection;
}
