<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    public function render()
    {       
        return response()->json(
            [
                "error" => true,
                "message" => "User Not Found!"
            ],
            404
        );
    }   
}
