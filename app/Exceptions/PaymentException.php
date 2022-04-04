<?php

namespace App\Exceptions;

use Exception;

class PaymentException extends Exception
{
    public function render()
    {
        return redirect()->back()->withErrors($this->getMessage());
    }
}
