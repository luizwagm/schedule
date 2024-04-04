<?php

namespace App\Events;

use App\Http\Requests\User\UserRequest;
use Illuminate\Foundation\Events\Dispatchable;

class CreateUserEvent
{
    use Dispatchable;

    /**
     * $userId variable
     *
     * @var integer
     */
    public int $userId;

    /**
     * Constructs function
     *
     * @param UserRequest $user
     */
    public function __construct(
        public UserRequest $user
    ) {}

    /**
     * set userId function
     *
     * @param integer $userId
     * @return void
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }
}
