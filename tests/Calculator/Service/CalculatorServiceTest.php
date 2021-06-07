<?php

namespace App\Tests\Calculator\Service;

use App\Calculator\Calculations\Division;
use App\Calculator\Calculations\Multiplication;
use App\Calculator\Calculations\Substraction;
use App\Calculator\Calculations\Sum as Sum;
use App\Calculator\Service\CalculatorService;
use App\System\Exceptions\CalculatorException;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class CalculatorServiceTest extends TestCase
{
    private $request;

    private array $testParameters;

    private CalculatorService $calculatorService;

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
        $this->testParameters = [
            'Sum' => [
                'calculator' => [
                    'operand' => 'Sum',
                    'parameter1' => 1,
                    'parameter2' => 3,
                    'result' => 4
                ]
            ],
            'Substraction' => [
                'calculator' => [
                    'operand' => 'Substraction',
                    'parameter1' => 3,
                    'parameter2' => 1,
                    'result' => 2
                ]
            ],
            'Multiplication' => [
                'calculator' => [

                    'operand' => 'Multiplication',
                    'parameter1' => 3,
                    'parameter2' => 3,
                    'result' => 9
                ]
            ],
            'Division' => [
                'calculator' => [
                    'operand' => 'Division',
                    'parameter1' => 9,
                    'parameter2' => 3,
                    'result' => 3
                ]
            ],
            'Unsupported' => [
                'calculator' => [
                    'operand' => 'Cosinus',
                    'parameter1' => 9,
                    'parameter2' => 3
                ]
            ]
        ];
    }

    public function testWillBuildService()
    {
        $this->request->request
            ->expects($this->any())
            ->method('get')
            ->willReturn(
                $this->testParameters['Sum']['calculator'],
            );
        $this->calculatorService = new CalculatorService(
            $this->request,
            new ArrayCollection(
                [
                    $this->createMock(Sum::class),
                    $this->createMock(Substraction::class),
                    $this->createMock(Multiplication::class),
                    $this->createMock(Division::class)
                ]
            )
        );
        $this->assertInstanceOf(CalculatorService::class, $this->calculatorService);
    }

    public function testWillHandleUnsupportedCaclulationType()
    {
        $this->expectException(CalculatorException::class);
        $this->request->request
            ->expects($this->exactly(3))
            ->method('get')
            ->willReturn(
                $this->testParameters['Unsupported']['calculator']
            );
        $this->calculatorService = new CalculatorService(
            $this->request,
            new ArrayCollection(
                [
                    new Sum(),
                    new Substraction(),
                    new Multiplication(),
                    new Division()
                ]
            )
        );
        $this->calculatorService->getResult();
    }

    public function testWillCalculateSum()
    {
        $this->request->request
            ->expects($this->exactly(3))
            ->method('get')
            ->willReturn(
                $this->testParameters['Sum']['calculator']
            );
        $this->calculatorService = new CalculatorService(
            $this->request,
            new ArrayCollection(
                [
                    new Sum(),
                    new Substraction(),
                    new Multiplication(),
                    new Division()
                ]
            )
        );
        $this->assertEquals(
            $this->testParameters['Sum']['calculator']['result'],
            $this->calculatorService->getResult()
        );
    }

    public function testWillCalculateSubstraction()
    {
        $this->request->request
            ->expects($this->exactly(3))
            ->method('get')
            ->willReturn(
                $this->testParameters['Substraction']['calculator'],
            );
        $this->calculatorService = new CalculatorService(
            $this->request,
            new ArrayCollection(
                [
                    new Sum(),
                    new Substraction(),
                    new Multiplication(),
                    new Division()
                ]
            )
        );
        $this->assertEquals(
            $this->testParameters['Substraction']['calculator']['result'],
            $this->calculatorService->getResult()
        );
    }

    public function testWillCalculateMultiplication()
    {
        $this->request->request
            ->expects($this->exactly(3))
            ->method('get')
            ->willReturn(
                $this->testParameters['Multiplication']['calculator'],
            );
        $this->calculatorService = new CalculatorService(
            $this->request,
            new ArrayCollection(
                [
                    new Sum(),
                    new Substraction(),
                    new Multiplication(),
                    new Division()
                ]
            )
        );
        $this->assertEquals(
            $this->testParameters['Multiplication']['calculator']['result'],
            $this->calculatorService->getResult()
        );
    }

    public function testWillCalculateDivision()
    {
        $this->request->request
            ->expects($this->exactly(3))
            ->method('get')
            ->willReturn(
                $this->testParameters['Division']['calculator'],
            );
        $this->calculatorService = new CalculatorService(
            $this->request,
            new ArrayCollection(
                [
                    new Sum(),
                    new Substraction(),
                    new Multiplication(),
                    new Division()
                ]
            )
        );
        $this->assertEquals(
            $this->testParameters['Division']['calculator']['result'],
            $this->calculatorService->getResult()
        );
    }
}