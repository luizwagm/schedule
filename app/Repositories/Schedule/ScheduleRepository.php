<?php

namespace App\Repositories\Schedule;

use App\Exceptions\ScheduleNotCreateException;
use App\Exceptions\ScheduleNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\Schedule\ScheduleFilterRequest;
use App\Http\Requests\Schedule\ScheduleRequest;
use App\Http\Requests\Schedule\ScheduleUpdateRequest;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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
        
        $schedule = $this->model->find($id);

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
        
        return $this->model
            ->where('user_id', $user?->id)
            ->orderBy('created_at', 'desc')
            ->first()
            ->id;            
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
                'user_id' => $user?->id,
            ]
        );

        if (! $createSchedule) {
            throw new ScheduleNotCreateException();
        }

        return $createSchedule;
    }

    public function update(ScheduleUpdateRequest $request, int $id): Schedule
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

        $schedule->start_date = $request?->start_date ?? $schedule->start_date;
        $schedule->end_date = $request?->end_date ?? $schedule->end_date;
        $schedule->title = $request?->title ?? $schedule->title;
        $schedule->type = $request?->type ?? $schedule->type;
        $schedule->status = $request?->status ?? $schedule->status;
        $schedule->description = $request?->description ?? $schedule->description;

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

    public function dateAlreadyUse(Request $request): Schedule|null
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        return $this->model
            ->where('user_id', $user->id)
            ->where('start_date', '<=', $request->start_date)
            ->where('end_date', '>', $request->start_date)
            ->where('status', Schedule::OPEN)
            ->first();
    }

    public function filter(ScheduleFilterRequest $request): Collection
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }

        return $this->model
            ->where('user_id', $user->id)
            ->whereBetween('start_date', [$request?->from_date, $request?->to_date])
            ->get();
    }

    public function all(): Collection
    {
        $user = auth()?->user();

        if (! $user) {
            throw new UserNotFoundException();
        }
        
        return $this->model->where('user_id', $user?->id)->get();
    }
}
