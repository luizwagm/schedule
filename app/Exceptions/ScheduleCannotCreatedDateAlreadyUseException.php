<?php

namespace App\Exceptions;

use Exception;

class ScheduleCannotCreatedDateAlreadyUseException extends Exception
{
    public function render()
    {       
        return response()->json(
            [
                "error" => true,
                "message" => "Schedule cannot be created because the date is already in use!"
            ],
            422
        );
    }   
}
