<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted("ROLE_ADMIN")]
#[Route("/admin")]
class AdminHomeController extends AbstractController
{
    #[Route('/home', 'app_admin_home_index')]
    public function index(): Response
    {
        return $this->render('admin/home/index.html.twig');
    }
}
