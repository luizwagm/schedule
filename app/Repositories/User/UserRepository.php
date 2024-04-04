<?php

namespace App\Repositories\User;

use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Construct function
     *
     * @param User $user
     */
    public function __construct(
        protected User $model
    ) {}

    /**
     * Get function
     *
     * @param integer $id
     * @param string $document
     * @return User
     */
    public function get(int $id, string $document = ''): User
    {
        if (empty($document)) {
            return $this->model->find($id);
        }

        return $this->model->where('document', $document)->first();
    }

    /**
     * Create function
     *
     * @param UserRequest $request
     * @return User|Exception
     */
    public function create(UserRequest $request): User|Exception
    {
        try {
            return $this->model->create(
                [
                    'fullname' => $request?->fullname,
                    'document' => $request?->document_type == User::DOCUMENT_TYPE_CPF ? $request?->cpf : $request?->cnpj,
                    'email' => $request?->email,
                    'password' => $request?->password,
                    'user_type' => $request?->user_type,
                    'document_type' => $request?->document_type,
                    'phone' => $request?->phone,
                    'company_name' => $request?->company_name,
                    'state_registration' => $request?->state_registration
                ]
            );
        } catch (\Exception $e) {
            return $e;
        }
    }
}
