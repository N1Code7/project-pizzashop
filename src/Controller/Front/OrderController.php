<?php

namespace App\Controller\Front;

use App\DTO\Payment;
use App\Entity\User;
use App\Entity\Order;
use App\Form\PaymentType;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted("ROLE_USER")]
#[Route("/commander")]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_front_order_display')]
    public function display(Request $request, OrderRepository $repository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $payment = new Payment();
        $payment->address = $user->getAddress();

        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = new Order();
            $order->setUser($user);
            $order->setAddress($payment->address);

            foreach ($user->getBasket()->getArticles() as $article) {
                $order->addArticle($article);
            }

            $repository->add($order, true);

            return $this->redirectToRoute("app_front_order_validate", [
                "id" => $order->getId()
            ]);
        }

        return $this->render('front/order/display.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route("/{id}/validation", name: "app_front_order_validate")]
    public function validate(Order $order): Response
    {
        return $this->render("front/order/validate.html.twig", [
            "order" => $order
        ]);
    }
}
