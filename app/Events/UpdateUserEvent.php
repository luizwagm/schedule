<?php

namespace App\Events;

use App\Http\Requests\User\UserRequest;
use Illuminate\Foundation\Events\Dispatchable;

class UpdateUserEvent
{
    use Dispatchable;

    public function __construct(
        public UserRequest $user
    ) {}
}
