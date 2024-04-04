<?php

namespace App\Listeners;

use App\Events\UpdateUserEvent;
use App\Repositories\User\UserRepositoryInterface;

class UpdateUserListener
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    public function handle(UpdateUserEvent $event): void
    {
        $create = $this->repository->update($event?->user);
    }
}
