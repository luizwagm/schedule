<?php

namespace App\Repositories\User;

use App\Exceptions\UserNotCreateException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\User\UserRequest;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ) {}

    public function get(): User
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function getLasted(): User
    {       
        return $this->model
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function create(UserRequest $request): User
    {
        $createUser = $this->model->create(
            [
                'fullname' => $request?->fullname,
                'email' => $request?->email,
                'password' => $request?->password,
            ]
        );

        if (! $createUser) {
            throw new UserNotCreateException();
        }

        return $createUser;
    }

    public function update(UserRequest $request): User
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        $user = $this->model->find($user->id);

        if (! $user) {
            throw new UserNotFoundException();
        }

        $user->fullname = $request?->fullname;
        $user->password = $request?->password;

        $user->save();

        return $user;
    }

    public function delete(): void
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        $this->model->where('id', $user->id)->delete();
    }
}
