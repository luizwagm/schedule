<?php

namespace App\Repositories\Schedule;

use App\Http\Requests\Schedule\ScheduleRequest;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

interface ScheduleRepositoryInterface
{
    public function get(int $id): Schedule;
    public function create(ScheduleRequest $request): Schedule;
    public function update(ScheduleRequest $request, int $id): Schedule;
    public function delete(int $id): void;
    public function dateAlreadyUse(ScheduleRequest $request): Schedule;
    public function filter($request): Collection;
    public function getLastedId(): int;
}
