<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceInterface
{
    /**
     * Construct function
     *
     * @param UserRepositoryInterface $repository
     */
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    /**
     * Get user function
     *
     * @param integer $id
     * @param string $document
     * @return User
     */
    public function get(int $id, string $document = ''): User
    {
        return $this->repository->get($id, $document);
    }

    /**
     * Get all notifications function
     *
     * @param integer $id
     * @return Collection
     */
    public function notifications(int $id): Collection
    {
        return new Collection([]);
    }
}
