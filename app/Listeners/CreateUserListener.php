<?php

namespace App\Listeners;

use App\Events\CreateUserEvent;
use App\Repositories\User\UserRepositoryInterface;

class CreateUserListener
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    public function handle(CreateUserEvent $event): void
    {
        $create = $this->repository->create($event?->user);
    }
}
