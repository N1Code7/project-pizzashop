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
    public function create(Request $request, PizzaRepository $repository, int $id): Response
    {
        $form = $this->createForm(PizzaType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pizza = $form->getData();

            $repository->add($pizza, true);

            return $this->redirectToRoute("app_admin_pizza_list");
        }

        return $this->render('admin/pizza/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route("/liste", name: "app_admin_pizza_list")]
    public function list(PizzaRepository $repository): Response
    {
        $pizzas = $repository->findAll();

        return $this->render("admin/pizza/list.html.twig", [
            "pizzas" => $pizzas
        ]);
    }

    #[Route("/modifier/{id}", name: "app_admin_pizza_update")]
    public function update(Request $request, PizzaRepository $repository, int $id): Response
    {
        $pizza = $repository->find($id);

        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pizza = $form->getData();
            $repository->add($pizza, true);

            return $this->redirectToRoute("app_admin_pizza_list");
        }

        return $this->render("admin/pizza/update.html.twig", [
            "form" => $form->createView(),
            "pizza" => $pizza
        ]);
    }

    #[Route("/supprimer/{id}", name: "app_admin_pizza_delete")]
    public function delete(PizzaRepository $repository, int $id): Response
    {
        $pizza = $repository->find($id);

        $repository->remove($pizza, true);

        return $this->redirectToRoute("app_admin_pizza_list");
    }
}
