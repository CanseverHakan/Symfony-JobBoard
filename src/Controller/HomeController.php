<?php

namespace App\Controller;

use App\Repository\HomeSettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HomeSettingRepository $homeSettingRepository): Response
    {

        $setting = $homeSettingRepository->findAll();
        return $this->render('home/index.html.twig', [
            'setting' => $setting,
        ]);
    }
}
