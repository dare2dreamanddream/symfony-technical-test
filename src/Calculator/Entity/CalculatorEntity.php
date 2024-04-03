<?php

namespace App\Calculator\Entity;

use App\System\Traits\EntityTrait;

/**
 * @ORM\CalculatorEntity
 */

class CalculatorEntity
{
    use EntityTrait;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Type("float")
     */
    private float $parameter1;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Type("float")
     */
    private float $parameter2;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")

     */
    private string $operand;

    public function getParameter1(): float
    {
        return $this->parameter1;
    }

    public function setParameter1(float $parameter1): self
    {
        $this->parameter1 = $parameter1;
        return $this;
    }

    public function getParameter2(): float
    {
        return $this->parameter2;
    }

    public function setParameter2(float $parameter2): self
    {
        $this->parameter2 = $parameter2;
        return $this;
    }

    public function getOperand(): string
    {
        return $this->operand;
    }

    public function setOperand(string $operand): self
    {
        $this->operand = $operand;
        return $this;
    }

    public function fromRequest(): self
    {
        return $this
                ->setOperand($this->request->request->get('calculator')['operand'])
                ->setParameter1($this->request->request->get('calculator')['parameter1'])
                ->setParameter2($this->request->request->get('calculator')['parameter2']);
    }
}
