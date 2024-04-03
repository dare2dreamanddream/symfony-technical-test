<?php

namespace App\Calculator\Service;

use App\Calculator\Entity\CalculatorEntity;
use App\System\Exceptions\CalculatorException;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;

class CalculatorService
{
    private Request $request;

    private CalculatorEntity $calculatorEntity;

    private Collection $calculations;

    public function __construct(
        Request $request,
        ?Collection $calculations = null
    ) {
        return $this
            ->setRequest($request)
            ->setCalculations($calculations)
            ->setEntity();
    }

    private function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    private function setCalculations(?Collection $calculations): self
    {
        if ($calculations !== null) {
            $this->calculations = $calculations;
        } else {
            throw new CalculatorException('No calculation types provided to calculator service.');
        }
        return $this;
    }

    private function setEntity(): self
    {
        try {
            $this->calculatorEntity = (new CalculatorEntity($this->request));
        } catch (\Exception $exception) {
            throw new CalculatorException('Parameter error.');
        }
        return $this;
    }

    public function getResult(): float
    {
        foreach ($this->calculations as $calculation) {
            if (is_a($calculation, 'App\Calculator\Calculations\\' . $this->calculatorEntity->getOperand())) {
                return $calculation->calculate(
                    $this->calculatorEntity->getParameter1(),
                    $this->calculatorEntity->getParameter2()
                );
            }
        }
        throw new CalculatorException('Requested calculation type is not supported.');
    }
}