<?php

namespace App\Repositories\Schedule;

use App\Http\Requests\Schedule\ScheduleFilterRequest;
use App\Http\Requests\Schedule\ScheduleRequest;
use App\Http\Requests\Schedule\ScheduleUpdateRequest;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ScheduleRepositoryInterface
{
    public function get(int $id): Schedule;
    public function create(ScheduleRequest $request): Schedule;
    public function update(ScheduleUpdateRequest $request, int $id): Schedule;
    public function delete(int $id): void;
    public function dateAlreadyUse(Request $request): Schedule|null;
    public function filter(ScheduleFilterRequest $request): Collection;
    public function getLastedId(): int;
    public function all(): Collection;
}
