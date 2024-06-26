<?php

namespace App\Services\Schedule;

use App\Http\Requests\Schedule\ScheduleFilterRequest;
use App\Models\Schedule;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ScheduleService implements ScheduleServiceInterface
{
    public function __construct(
        protected ScheduleRepositoryInterface $repository
    ) {}

    public function get(int $id): Schedule
    {
        return $this->repository->get($id);
    }

    public function notifications(int $id): Collection
    {
        return new Collection([]);
    }

    public function getLatestSchedule(): Schedule
    {
        return $this->get($this->repository->getLastedId());
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function filter(ScheduleFilterRequest $request): Collection
    {
        return $this->repository->filter($request);
    }
}
