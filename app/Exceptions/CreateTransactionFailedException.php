<?php

namespace App\Exceptions;

use Exception;

class CreateTransactionFailedException extends Exception
{
    public function render()
    {       
        return response()->json(
            [
                "error" => true,
                "message" => "Financial transaction permitted only for common users"
            ],
            422
        );
    }   
}
