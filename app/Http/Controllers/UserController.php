<?php

namespace App\Http\Controllers;

use App\Events\CreateUserEvent;
use App\Events\UpdateUserEvent;
use App\Exceptions\IdNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\CreatedUserResource;
use App\Http\Resources\User\GetUserResource;
use App\Http\Resources\User\UpdatedUserResource;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserServiceInterface $service
    ) {}

    /**
    * @OA\Post(
     *     path="/api/V1/create",
     *     summary="Create a new user",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="fullname",
     *         in="query",
     *         description="User's fullname",
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
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="User registered successfully", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Do not create an existing user", @OA\JsonContent())
     * )
     */
    public function create(UserRequest $request): JsonResponse
    {
        CreateUserEvent::dispatch($request);

        return response()->json(
            new CreatedUserResource(
                $this->service->getLatestUser()
            )
        , 201);
    }

    /**
    * @OA\Get(
     *     path="/api/V1/user",
     *     summary="Get user",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Get user", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User not found", @OA\JsonContent())
     * )
     */
    public function get(): JsonResponse
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        return response()->json(
            new GetUserResource(
                $this->service->get()
            )
        , 200);
    }

    /**
    * @OA\Put(
     *     path="/api/V1/user",
     *     summary="Update a user",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="fullname",
     *         in="query",
     *         description="User's fullname",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         @OA\Schema(type="string")
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="User updated successfully", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Do not update user", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User not found", @OA\JsonContent())
     * )
     */
    public function update(UserUpdateRequest $request): JsonResponse
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        UpdateUserEvent::dispatch($request);

        return response()->json(
            new UpdatedUserResource(
                $this->service->get($user?->id)
            )
        , 200);
    }

    /**
    * @OA\Post(
     *     path="/api/V1/user/delete",
     *     summary="Remove user",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="User removed successfully", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User not found", @OA\JsonContent())
     * )
     */
    public function delete(): JsonResponse
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        $this->service->delete($user?->id);

        return response()->json(
            [
                'message' => 'User removed successfully!'
            ]
        , 200);
    }
}
