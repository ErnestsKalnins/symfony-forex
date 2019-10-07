<?php

namespace App\Controller;

use App\Entity\ForexRate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ForexController extends AbstractController
{
    /**
     * @Route("/", name="forex")
     */
    public function index()
    {
        $forexRepo = $this->getDoctrine()->getManager()->getRepository(ForexRate::class);

        $availableDates = $forexRepo->availableDates();

        $forexRates = $forexRepo->ratesAtDate($availableDates[0]);

        return $this->render('forex/index.html.twig', [
            'availableDates' => $availableDates,
            'forexRates' => $forexRates,
        ]);
    }
}
