<?php

namespace src;

class ValidationEmail
{
    public function validateRule($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function getErrorMessage()
    {
        return "Formato do e-mail incorreto.";
    }
}