<?php

namespace App\Calculator\Controller;

use App\Calculator\Calculations\Division;
use App\Calculator\Calculations\Multiplication;
use App\Calculator\Calculations\Substraction;
use App\Calculator\Calculations\Sum as Sum;
use App\Calculator\Form\CalculatorType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Calculator\Service\CalculatorService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculatorController extends AbstractController
{
    /**
     * @Route("/calculator", name="home")
     */
    public function getForm()
    {
        $form = $this->createForm(CalculatorType::class);
        return $this->render('calculator.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/result", name="result")
     * @param Request $request
     * @return Response
     */
    public function getResult(
        Request $request
    ): Response {
        try {
            $form = $this->createForm(CalculatorType::class);
            $form->handleRequest($request);

            return $this->render('calculator.html.twig', [
                'form' => $form->createView(),
                'result' => (new CalculatorService(
                    $request,
                    $this->getCalculations()
                ))
                    ->getResult()
            ]);
        } catch (\Exception $exception) {
            new Response($exception->getMessage(), 500);
        }
    }

    public function getCalculations(): ArrayCollection
    {
        return new ArrayCollection(
            [
                new Sum(),
                new Substraction(),
                new Multiplication(),
                new Division()
            ]
        );
    }
}
