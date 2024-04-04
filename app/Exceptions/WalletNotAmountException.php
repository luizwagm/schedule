<?php

namespace App\Exceptions;

use Exception;

class WalletNotAmountException extends Exception
{
    public function render()
    {       
        return response()->json(
            [
                "error" => true,
                "message" => "Financial transaction without value in the wallet"
            ],
            422
        );
    }
}
