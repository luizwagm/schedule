<?php

namespace App\Events;

use App\Http\Requests\User\UserUpdateRequest;
use Illuminate\Foundation\Events\Dispatchable;

class UpdateUserEvent
{
    use Dispatchable;

    public function __construct(
        public UserUpdateRequest $user
    ) {}
}
