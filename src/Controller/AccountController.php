<?php

namespace App\Controller;

use App\Repository\UserProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(string $slug, UserProfilRepository $userProfilRepository): Response
    {

        $user = $this->getUser();

        $connectedUserProfil = $userProfilRepository->findBy(['user' => $user]);

        $userProfil = $userProfilRepository->findOneBy(['slug' => $user]);


        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }
}
