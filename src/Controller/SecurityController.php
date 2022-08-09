<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Basket;
use App\Entity\Address;
use App\Form\EditProfileType;
use App\Form\EditPasswordType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Repository\BasketRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route(path: "/inscription", name: "app_security_registration")]
    public function registration(Request $request, UserRepository $repository, BasketRepository $repo2, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(RegistrationType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $basket = $user->getBasket();
            $basket->setUser($user);

            $hashedPassword = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $repository->add($user, true);
            $repo2->add($basket, true);

            return $this->redirectToRoute("app_security_login");
        }

        return $this->render("security/registration.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route(path: '/connexion', name: 'app_security_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/deconnexion', name: 'app_security_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[IsGranted("ROLE_USER")]
    #[Route("/mon-profil", name: "app_security_displayProfile")]
    public function setProfile(): Response
    {
        return $this->render("security/displayProfile.html.twig");
    }

    #[IsGranted("ROLE_USER")]
    #[Route("/mon-profil/editer", name: "app_security_editProfile")]
    public function editProfile(Request $request, UserRepository $repository): Response
    {
        $user = $this->getUser();
        // dd($user);
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $repository->add($user, true);

            $this->addFlash("success", "Vos informations ont été mises à jour :)");

            return $this->redirectToRoute("app_security_displayProfile");
        }

        return $this->render("security/editProfile.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[IsGranted("ROLE_USER")]
    #[Route("/mon-profil/changer-pass", name: "app_security_editPassword")]
    public function editPassword(UserRepository $repository, Request $request, UserPasswordHasherInterface $hasher,): Response
    {
        /** @var User */
        $user = $this->getUser();
        // dd($user);
        $form = $this->createForm(EditPasswordType::class);

        $form->handleRequest($request);

        // dd($previousPassword, $validPassword);

        if ($form->isSubmitted() && $form->isValid()) {
            $previousPassword = $form->getData()->previousPassword;
            $newPassword = $form->getData()->getPassword();

            $validPassword = $hasher->isPasswordValid($user, $previousPassword);

            if ($validPassword) {
                $hashedPassword = $hasher->hashPassword($user, $newPassword);

                $repository->upgradePassword($user, $hashedPassword);

                $this->addFlash("success", "Mots de passe identiques");

                return $this->redirectToRoute("app_security_editProfile");
            } else {
                $this->addFlash("error", "Les MDP ne correspondent pas !");
            }
        }

        return $this->render("security/editPassword.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
