<?php

namespace App\Exceptions;

use Exception;

class ScheduleNotFoundException extends Exception
{
    public function render()
    {       
        return response()->json(
            [
                "error" => true,
                "message" => "Schedule Not Create!"
            ],
            404
        );
    }   
}
