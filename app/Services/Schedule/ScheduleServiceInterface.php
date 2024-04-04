<?php

namespace App\Services\Schedule;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

interface ScheduleServiceInterface
{
    public function get(int $id): Schedule;
    public function notifications(int $id): Collection;
    public function getLatestSchedule(): Schedule;
    public function delete(int $id): void;
}
