<?php

namespace App\Controller;

use App\Entity\EntrepriseProfil;
use App\Form\EntrepriseProfilType;
use App\Services\UploadFilesServices;
use Cocur\Slugify\Slugify;
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

        $user = $this->getUser();

        $entrepriseProfil = new EntrepriseProfil;

        $form = $this->createForm(EntrepriseProfilType::class, $entrepriseProfil);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entrepriseProfil->setUser($user);
            $slugify = new Slugify();
            $entrepriseProfil->setSlug($slugify->slugify($entrepriseProfil->getName()). '-' .sha1($user->getId()));

            $file = $form['logo']->getData();
            if($file){
                $fileName = $uploadServices->saveFileUpload($file);
                $entrepriseProfil->setLogo($fileName);
            }

            $em->persist($entrepriseProfil);
            $em->flush();
        }

        return $this->render('entreprise/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
