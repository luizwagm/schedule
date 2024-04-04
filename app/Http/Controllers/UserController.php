<?php

namespace App\Http\Controllers;

use App\Events\CreateUserEvent;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\CreatedUserResource;
use App\Http\Resources\User\GetUserResource;
use App\Models\User;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Construct function
     *
     * @param UserServiceInterface $service
     */
    public function __construct(
        protected UserServiceInterface $service
    ) {}

    /**
    * @OA\Post(
     *     path="/api/V2/create",
     *     summary="Create a new user",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *         name="fullname",
     *         in="query",
     *         description="User's fullname",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="document_type",
     *         in="query",
     *         description="Document type",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={
     *                   "cpf",
     *                   "cnpj",
     *             },
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="cpf",
     *         in="query",
     *         description="User's cpf",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="cnpj",
     *         in="query",
     *         description="User's cnpj",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="User's phone",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="company_name",
     *         in="query",
     *         description="User's company name",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="state_registration",
     *         in="query",
     *         description="User's state registration",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="user_type",
     *         in="query",
     *         description="User type",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={
     *                   "seller",
     *                   "buyer",
     *                   "engineer",
     *             },
     *         )
     *     ),
     *     @OA\Response(response="201", description="User registered successfully", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Do not create an existing user", @OA\JsonContent())
     * )
     */
    public function create(UserRequest $request): JsonResponse
    {
        CreateUserEvent::dispatch($request);

        $getUser = $this->service->get(0, 
                $request[
                    $request->document_type == User::DOCUMENT_TYPE_CPF ? 'cpf' : 'cnpj'
                ]
            );

        return response()->json(new CreatedUserResource($getUser), 201);
    }

    /**
    * @OA\Get(
     *     path="/api/V2/user/{id}",
     *     summary="Get user",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User's id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get user with wallet")
     * )
     */
    public function get(int $id): GetUserResource
    {
        return new GetUserResource($this->service->get($id));
    }
}
