<?php

namespace App\Exceptions;

use Exception;

class ScheduleCannotCreatedOnWeekendsException extends Exception
{
    public function render($complement = '')
    {       
        return response()->json(
            [
                "error" => true,
                "message" => "Schedule cannot be created on weekends.",
                "complement" => $complement
            ],
            422
        );
    }   
}
