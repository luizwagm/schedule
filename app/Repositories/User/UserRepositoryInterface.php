<?php

namespace App\Repositories\User;

use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Exception;

interface UserRepositoryInterface
{
    /**
     * Get function
     *
     * @param integer $id
     * @param string $document
     * @return User
     */
    public function get(int $id, string $document = ''): User;

    /**
     * Create function
     *
     * @param UserRequest $request
     * @return User|Exception
     */
    public function create(UserRequest $request): User|Exception;
}
