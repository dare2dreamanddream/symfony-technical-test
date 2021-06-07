<?php

namespace App\Tests\Calculator\Entity;

use App\Calculator\Entity\CalculatorEntity;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class CalculatorEntityTest extends TestCase
{
    private $request;

    private array $testParameters;

    private CalculatorEntity $calculatorEntity;

    public function setUp(): void
    {
        $this
            ->setRequest()
            ->setTestParameters();
        parent::setUp();
    }

    public function setRequest(): self
    {
        $this->request = $this->createMock(Request::class);
        $this->request->request = $this->createMock(ParameterBag::class);
        return $this;
    }

    public function setTestParameters()
    {
        $this->testParameters = ['calculator' => [
                'operand' => 'Sum',
                'parameter1' => 1,
                'parameter2' => 3
            ]
        ];
    }

    public function testBuildFromRequest()
    {
        $this->request->request
            ->expects($this->any())
            ->method('get')
            ->willReturn(
                $this->testParameters['calculator']
            );
        $this->calculatorEntity = new CalculatorEntity($this->request);
        $this->assertEquals(
            $this->testParameters['calculator']['operand'],
            $this->calculatorEntity->getOperand()
        );
        $this->assertEquals(
            $this->testParameters['calculator']['parameter1'],
            $this->calculatorEntity->getParameter1()
        );
        $this->assertEquals(
            $this->testParameters['calculator']['parameter2'],
            $this->calculatorEntity->getParameter2()
        );
    }
}