<?php

namespace App\Repositories\User;

use App\Http\Requests\User\UserRequest;
use App\Models\User;

interface UserRepositoryInterface
{
    public function get(): User;
    public function create(UserRequest $request): User;
    public function update(UserRequest $request): User;
    public function delete(): void;
    public function getLasted(): User;
}
