<?php

namespace src;

class Validation
{
    private $rules;
    private $errorMessages;

    public function __construct()
    {
        $this->rules = [];
        $this->errorMessages = [];
    }

    public function addRule($rule)
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function validate($value)
    {
        foreach ($this->rules as $rule) {
            $ruleValidation = $rule->validateRule($value);
            if (!$ruleValidation) {
                $this->errorMessages[] = $rule->getErrorMessage();
                return false;
            }
        }

        return true;
    }

    public function getAllErrorMessages()
    {
        return $this->errorMessages;
    }

    public function cleanRules()
    {
        $this->rules = [];
        return $this;
    }
}