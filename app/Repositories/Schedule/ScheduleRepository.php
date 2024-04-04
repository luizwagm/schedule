<?php

namespace App\Repositories\Schedule;

use App\Exceptions\ScheduleNotCreateException;
use App\Exceptions\ScheduleNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\Schedule\ScheduleRequest;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

class ScheduleRepository implements ScheduleRepositoryInterface
{
    public function __construct(
        protected Schedule $model
    ) {}

    public function get(int $id): Schedule
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }
        
        $schedule = $this->model->with('user')->find($id);

        if (! $schedule) {
            throw new ScheduleNotFoundException();
        }

        return $schedule;
    }

    public function getLastedId(): int
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }
        
        $schedules = $this->model
            ->with('user')
            ->where('user_id', $user?->id)
            ->get();

        return $schedules->latest()->first()->id;
    }

    public function create(ScheduleRequest $request): Schedule
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        $createSchedule = $this->model->create(
            [
                'start_date' => $request?->start_date,
                'end_date' => $request?->end_date,
                'status' => Schedule::OPEN,
                'title' => $request?->title,
                'type' => $request?->type,
                'description' => $request?->description,
                'user_id' => $request?->$user->id,
            ]
        );

        if (! $createSchedule) {
            throw new ScheduleNotCreateException();
        }

        return $createSchedule;
    }

    public function update(ScheduleRequest $request, int $id): Schedule
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        $schedule = $this->model
            ->where('id', $id)
            ->where('status', '!=', Schedule::CONCLUDED)
            ->first();

        if (! $schedule) {
            throw new ScheduleNotFoundException();
        }

        $schedule->start_date = $request?->start_date;
        $schedule->end_date = $request?->end_date;
        $schedule->title = $request?->title;
        $schedule->type = $request?->type;
        $schedule->status = $request?->status;
        $schedule->description = $request?->description;

        $schedule->save();

        return $schedule; //observar se esta pegando atualizado
    }

    public function delete(int $id): void
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        $schedule = $this->model->find($id);

        if (! $schedule) {
            throw new ScheduleNotFoundException();
        }

        $this->model->where('id', $id)->delete();
    }

    public function dateAlreadyUse(ScheduleRequest $request): Schedule
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        $getSchedule = $this->model->where('user_id', $user->id)->get();

        return $getSchedule
            ->where('start_date', '>=', $request?->start_date)
            ->where('end_date', '<=', $request?->end_date)
            ->first();
    }

    public function filter($request): Collection
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        $getSchedule = $this->model->where('user_id', $user->id)->get();

        $filter = $getSchedule
            ->whereDate('start_date', '>=', $request?->from_date)
            ->whereDate('start_date', '<=', $request?->to_date)
            ->get();

        return $filter;
    }
}
