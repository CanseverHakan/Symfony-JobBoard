<?php

namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Entity\EntrepriseProfil;
use App\Form\EntrepriseProfilType;
use App\Services\UploadFilesServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\EntrepriseProfilRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

#[Route('/account')]
class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(Request $request, EntityManagerInterface $em, UploadFilesServices $uploadServices): Response
    {

        $user = $this->getUser();

        if($user->getEntrepriseProfil()){
            return $this->redirectToRoute('app_entreprise_show', ['slug' => $user->getEntrepriseProfil()->getSlug()]);
        }

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

    //EDIT
    // #[Route('/entreprise/{slug}/edit', name: 'app_entreprise_edit')]
    // public function editEntrepriseProfil(string $slug, Request $request, EntrepriseProfilRepository $entrepriseProfilRepository, UploadFilesServices $uploadFilesService, EntityManagerInterface $em): Response
    // {
    //     $user = $this->getUser();

    //     $entrepriseProfil = $entrepriseProfilRepository->findOneBy(['slug' => $slug]);

    //     if (!$entrepriseProfil || $entrepriseProfil->getUser() !== $user) {
    //         return $this->redirectToRoute('app_entreprise_show', ['slug' => $entrepriseProfil->getSlug()]);
    //     }

    //     $form = $this->createForm(EntrepriseProfilType::class, $entrepriseProfil);

    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()){

    //         $file = $form['logo']->getData();

    //         if($file){

    //             $fileName = $uploadFilesService->updateFileUpload($file,$entrepriseProfil->getLogo());
    //             $entrepriseProfil->setLogo($fileName);
    //         }

    //         $em->flush();

    //         return $this->redirectToRoute('app_entreprise_show', ['slug' => $entrepriseProfil->getSlug()]);
            
    //     }

    //     return $this->render('entreprise/edit.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }

    #[Route('/entreprise/{slug}', name: 'app_entreprise_show')]
    public function show(EntrepriseProfil $entrepriseProfil): Response
    {
        return $this->render('entreprise/show.html.twig', [
            'entrepriseProfil' => $entrepriseProfil,
        ]);
    }
}
