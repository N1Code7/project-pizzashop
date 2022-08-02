<?php

namespace App\Controller\Admin;

use App\Form\PizzaType;
use App\Repository\PizzaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/admin/pizza")]
class AdminPizzaController extends AbstractController
{
    #[Route('/nouvelle', name: 'app_admin_pizza_create')]
    public function create(Request $request, PizzaRepository $repository): Response
    {
        $form = $this->createForm(PizzaType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pizza = $form->getData();

            $repository->add($pizza, true);

            return $this->redirectToRoute("app_security_login");
        }

        return $this->render('admin/pizza/create.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
