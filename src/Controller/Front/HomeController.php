<?php

namespace App\Controller\Front;

use App\Repository\PizzaRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// #[IsGranted("ROLE_USER")]
class HomeController extends AbstractController
{
    #[Route('/accueil', name: 'app_front_home_index')]
    public function index(PizzaRepository $repository): Response
    {
        $pizzas = $repository->findAll();

        return $this->render('front/home/index.html.twig', [
            'pizzas' => $pizzas
        ]);
    }
}
