<?php

namespace App\Controller;

use App\Entity\EntrepriseProfil;
use App\Form\EntrepriseProfilType;
use App\Services\UploadFilesServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/account')]
class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(Request $request, EntityManagerInterface $em, UploadFilesServices $uploadServices): Response
    {

        $entrepriseProfil = new EntrepriseProfil;

        $form = $this->createForm(EntrepriseProfilType::class, $entrepriseProfil);
        
        $form->handleRequest($request);

        return $this->render('entreprise/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
