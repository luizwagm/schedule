<?php

namespace App\Exceptions;

use Exception;

class UserNotCreateException extends Exception
{
    public function render()
    {       
        return response()->json(
            [
                "error" => true,
                "message" => "User Not Create!"
            ],
            422
        );
    }   
}
