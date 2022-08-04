<?php

namespace App\Controller\Front;

use App\Entity\Pizza;
use App\Entity\Article;
use App\Repository\BasketRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted("ROLE_USER")]
#[Route("/mon-panier")]
class BasketController extends AbstractController
{
    #[Route('/', name: 'app_front_basket_display')]
    public function display(): Response
    {
        return $this->render('front/basket/display.html.twig');
    }

    #[Route("/{id}/ajouter", name: "app_front_basket_addArticle")]
    public function addArticle(BasketRepository $repository, Pizza $pizza): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $basket = $user->getBasket();

        $article = new Article();
        $article->setQuantity(1);
        $article->setBasket($basket);
        $article->setPizza($pizza);

        $basket->addArticle($article);

        $repository->add($basket, true);

        return $this->redirectToRoute("app_front_basket_display");
    }

    #[Route("/{id}/supprimer", name: "app_front_basket_deleteArticle")]
    public function deleteArticle(BasketRepository $basketRepo, ArticleRepository $articleRepo, int $id): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $basket = $user->getBasket();

        $articleToDelete = $articleRepo->find($id);

        $basket->removeArticle($articleToDelete);

        $basketRepo->add($basket, true);

        return $this->redirectToRoute("app_front_basket_display");
    }

    #[Route("/{id}/plus", name: "app_front_basket_increase")]
    public function increase(Article $article, ArticleRepository $repository): Response
    {
        $article->setQuantity(($article->getQuantity() + 1));
        $repository->add($article, true);

        return $this->redirectToRoute("app_front_basket_display");
    }

    #[Route("/{id}/moins", name: "app_front_basket_decrease")]
    public function decrease(Article $article, ArticleRepository $articleRepo, BasketRepository $basketRepo): Response
    {
        if ($article->getQuantity() <= 1) {
            /** @var User $user */
            $user = $this->getUser();
            $user->getBasket()->removeArticle($article);

            $basketRepo->add($user->getBasket(), true);
        } else {
            $article->setQuantity($article->getQuantity() - 1);
            $articleRepo->add($article, true);
        }

        return $this->redirectToRoute("app_front_basket_display");
    }
}
