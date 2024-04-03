<?php

namespace App\Calculator\Form;

use App\Calculator\Controller\CalculatorController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('POST')
            ->setAction('/result')
            ->add(
                'parameter1',
                TextType::class,
                ['attr' => ['maxlength' => 255]]
            )
            ->add(
                'parameter2',
                TextType::class,
                ['attr' => ['maxlength' => 255]]
            )
            ->add(
                'operand',
                ChoiceType::class,
                ['choices'  => $this->getAvailableCalculations(
                    (new CalculatorController())
                            ->getCalculations()
                            ->toArray()
                )
                ]
            )
            ->add('Calculate', SubmitType::class)
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }

    private function getAvailableCalculations(array $calculations): array
    {
        $availableCalculations = [];
        foreach ($calculations as $calculation) {
            array_push(
                $availableCalculations,
                str_replace('App\Calculator\Calculations\\', '', get_class($calculation))
            );
        }
        return array_combine($availableCalculations, $availableCalculations);
    }
}