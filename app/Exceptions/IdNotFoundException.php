<?php

namespace App\Exceptions;

use Exception;

class IdNotFoundException extends Exception
{
    public function render()
    {       
        return response()->json(
            [
                "error" => true,
                "message" => "Id Not Found!"
            ],
            404
        );
    }   
}
