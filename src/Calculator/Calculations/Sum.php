<?php

namespace App\Calculator\Calculations;

class Sum implements CalculationInterface
{

    public function calculate(float $parameter1, float $parameter2): float
    {
        return $parameter1 + $parameter2;
    }
}
