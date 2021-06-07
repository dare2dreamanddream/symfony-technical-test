<?php

namespace App\Calculator\Calculations;

interface CalculationInterface
{
    public function calculate(float $parameter1, float $parameter2): float;
}