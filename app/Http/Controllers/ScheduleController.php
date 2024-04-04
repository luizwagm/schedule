<?php

namespace App\Http\Controllers;

use App\Events\CreateScheduleEvent;
use App\Events\UpdateScheduleEvent;
use App\Exceptions\EndDateNeededLessStartDateException;
use App\Exceptions\IdNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\Schedule\ScheduleFilterRequest;
use App\Http\Requests\Schedule\ScheduleRequest;
use App\Http\Requests\Schedule\ScheduleUpdateRequest;
use App\Http\Resources\Schedule\CreatedScheduleResource;
use App\Http\Resources\Schedule\GetAllScheduleResource;
use App\Http\Resources\Schedule\GetScheduleResource;
use App\Http\Resources\Schedule\UpdatedScheduleResource;
use App\Services\Schedule\ScheduleServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    public function __construct(
        protected ScheduleServiceInterface $service
    ) {}

    /**
    * @OA\Post(
     *     path="/api/V1/schedule",
     *     summary="Create a new schedule",
     *     tags={"Schedule"},
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="Schedule's start_date",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="Schedule's end_date",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Schedule's title",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Schedule's type",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="Schedule's description",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="201", description="Schedule registered successfully", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User not found", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Schedule cannot be created because the date is already in use! | Schedule cannot be created on weekends. | Schedule Not Create!", @OA\JsonContent())
     * )
     */
    public function create(ScheduleRequest $request): JsonResponse
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        $startDate = new Carbon($request->start_date);
        $endDate = new Carbon($request->end_date);
        
        if ($endDate->timestamp < $startDate->timestamp) {
            throw new EndDateNeededLessStartDateException();
        }

        CreateScheduleEvent::dispatch($request);

        return response()->json(
            new CreatedScheduleResource(
                $this->service->getLatestSchedule()
            )
        , 201);
    }

    /**
    * @OA\Put(
     *     path="/api/V1/schedule/{id}",
     *     summary="Update a schedule",
     *     tags={"Schedule"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Schedule's id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="Schedule's start_date",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="Schedule's end_date",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Schedule's title",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Schedule's type",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="Schedule's description",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Schedule's status",
     *         @OA\Schema(
     *             type="string",
     *             enum={
     *                   "open",
     *                   "concluded",
     *             },
     *         )
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Schedule updated successfully", @OA\JsonContent()),
     *     @OA\Response(response="404", description="Id not found | Schedule not found exception. | User not found", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Schedule cannot be created because the date is already in use! | Schedule cannot be created on weekends.", @OA\JsonContent())
     * )
     */
    public function update(ScheduleUpdateRequest $request, int $id): JsonResponse
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        if (empty($id)) {
            throw new IdNotFoundException();
        }

        UpdateScheduleEvent::dispatch($request, $id); //observar aqui

        return response()->json(
            new UpdatedScheduleResource(
                $this->service->get($id)
            )
        , 200);
    }

    /**
    * @OA\Get(
     *     path="/api/V1/schedule/{id}",
     *     summary="Get a schedule",
     *     tags={"Schedule"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Schedule's id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Schedule get", @OA\JsonContent()),
     *     @OA\Response(response="404", description="Id not found | Schedule not found exception. | User not found", @OA\JsonContent())
     * )
     */
    public function get(int $id): JsonResponse
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        if (empty($id)) {
            throw new IdNotFoundException();
        }

        return response()->json(
            new GetScheduleResource(
                $this->service->get($id)
            )
        , 200);
    }

    /**
    * @OA\Post(
     *     path="/api/V1/schedule/delete/{id}",
     *     summary="Remove a schedule",
     *     tags={"Schedule"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Schedule's id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Schedule removed successfully", @OA\JsonContent()),
     *     @OA\Response(response="404", description="Id not found | Schedule not found exception. | User not found", @OA\JsonContent())
     * )
     */
    public function delete(int $id): JsonResponse
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        if (empty($id)) {
            throw new IdNotFoundException();
        }

        $this->service->delete($id);

        return response()->json(['message' => 'Schedule removed successfully!'], 200);
    }

    /**
    * @OA\Get(
     *     path="/api/V1/schedule/all",
     *     summary="Get all schedule",
     *     tags={"Schedule"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Schedule get", @OA\JsonContent()),
     *     @OA\Response(response="404", description="Id not found | Schedule not found exception. | User not found", @OA\JsonContent())
     * )
     */
    public function all(): JsonResponse
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        return response()->json(
            new GetAllScheduleResource(
                $this->service->all()
            )
        , 200);
    }

    /**
    * @OA\Post(
     *     path="/api/V1/schedule/filter",
     *     summary="Filter schedules",
     *     tags={"Schedule"},
     *     @OA\Parameter(
     *         name="from_date",
     *         in="query",
     *         required=true,
     *         description="Schedule's from date",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="to_date",
     *         in="query",
     *         required=true,
     *         description="Schedule's to date",
     *         @OA\Schema(type="string")
     *     ),
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Schedule get", @OA\JsonContent()),
     *     @OA\Response(response="404", description="Schedule not found | User not found", @OA\JsonContent())
     * )
     */
    public function filter(ScheduleFilterRequest $request): JsonResponse
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        return response()->json(
            new GetAllScheduleResource(
                $this->service->filter($request)
            )
        , 200);
    }
}
