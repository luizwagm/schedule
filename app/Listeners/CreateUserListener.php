<?php

namespace App\Listeners;

use App\Events\CreateUserEvent;
use App\Repositories\User\UserRepositoryInterface;

class CreateUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    /**
     * Handle the event.
     */
    public function handle(CreateUserEvent $event): void
    {
        $create = $this->repository->create($event->user);
        $event->setUserId($create->id);
    }
}
