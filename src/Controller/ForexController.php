<?php

namespace App\Controller;

use App\Entity\ForexRate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class ForexController extends AbstractController
{
    /**
     * @Route("/", name="forex")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $forexRepo = $this->getDoctrine()->getManager()->getRepository(ForexRate::class);
        $availableDates = $forexRepo->availableDates();

        $selectedDate = $request->query->get('date', $availableDates[0]);

        $forexRates = $paginator->paginate(
            $forexRepo->atDate($selectedDate),
            $request->query->getInt('page', 1),
            15
        );

        $forexRates->setParam('date', $selectedDate);

        return $this->render('forex/index.html.twig', [
            'availableDates' => $availableDates,
            'forexRates' => $forexRates,
        ]);
    }
}
