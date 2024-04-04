<?php

namespace App\Exceptions;

use Exception;

class ScheduleNotCreateException extends Exception
{
    public function render()
    {       
        return response()->json(
            [
                "error" => true,
                "message" => "Schedule Not Create!"
            ],
            422
        );
    }   
}
