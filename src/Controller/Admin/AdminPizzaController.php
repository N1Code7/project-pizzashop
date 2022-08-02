<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin/pizza")]
class AdminPizzaController extends AbstractController
{
    #[Route('/nouvelle', name: 'app_admin_pizza_create')]
    public function create(): Response
    {
        return $this->render('admin_pizza/index.html.twig', [
            'controller_name' => 'AdminPizzaController',
        ]);
    }
}
