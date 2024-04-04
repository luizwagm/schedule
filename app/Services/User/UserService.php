<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    public function get(): User
    {
        return $this->repository->get();
    }

    public function getLatestUser(): User
    {
        return $this->repository->getLasted();
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
