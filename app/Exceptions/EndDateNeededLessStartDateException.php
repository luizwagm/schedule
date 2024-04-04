<?php

namespace App\Exceptions;

use Exception;

class EndDateNeededLessStartDateException extends Exception
{
    public function render()
    {       
        return response()->json(
            [
                "error" => true,
                "message" => "End Date Needed Less Start Date"
            ],
            422
        );
    }   
}
