<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\UploadFilesServices;
use App\Entity\UserProfil;
use App\Form\UserProfilType;
use App\Repository\UserProfilRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/account')]
class UserProfilController extends AbstractController
{
    #[Route('/user/profil', name: 'app_user_profil')]
    public function index(Request $request, EntityManagerInterface $em, UploadFilesServices $uploadServices): Response
    {


        $user = $this->getUser();
        if ($user->getUserProfil()) {
            return $this->redirectToRoute('app_user_profil_show', ['slug' => $user->getUserProfil()->getSlug()]);
        }


        $userProfil = new UserProfil;
        $form = $this->createForm(UserProfilType::class, $userProfil);

        $slugify = new Slugify();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userProfil->setUser($this->getUser());
            $userProfil->setSlug($slugify->slugify($userProfil->getFirstName() . ' ' . $userProfil->getLastName()));

            $file = $form['imageFile']->getData();

            if ($file) {
                $files_Name = $uploadServices->saveFileUpload($file);
                $userProfil->setPicture($files_Name);
            } else {
                $userProfil->setImageFile('default.png');
            }

            $em->persist($userProfil);
            $em->flush();

            $this->addFlash('success', 'Votre profil a bien été créé !');

            return $this->redirectToRoute('app_user_profil_show', ['slug' => $userProfil->getSlug()]);
        }


        return $this->render('user_profil/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Affichage du profil utilisateur
    #[Route('/user/profil/{slug}', name: 'app_user_profil_show')]
    public function show(UserProfil $userProfil): Response
    {
        return $this->render('user_profil/show.html.twig', ['userProfil' => $userProfil,]);
    }

    //Modification du profil
    #[Route('/user/profil/edit/{slug}', name: 'app_user_profil_edit')]
    public function edit(string $slug, Request $request, EntityManagerInterface $em, UserProfilRepository $userRepository, UploadFilesServices $uploadServices): Response
    {

        $user = $this->getUser();
        $userProfil = $userRepository->findOneBy(['slug' => $slug]);


        if ($user != $userProfil->getUser()) {
            return $this->redirectToRoute('app_user_profil_show', ['slug' => $userProfil->getSlug()]);
        }

        $form = $this->createForm(UserProfilType::class, $userProfil);

        $form->handleRequest($request);

        $slugify = new Slugify();
        if ($form->isSubmitted() && $form->isValid()) {
            $userProfil->setSlug($slugify->slugify($userProfil->getFirstName() . ' ' . $userProfil->getLastName()));



            $file = $form['imageFile']->getData();

            if ($file) {
                $files_Name = $uploadServices->UpdateFileUpload($file, $userProfil->getPicture());
                $userProfil->setPicture($files_Name);
            }

            $em->flush();
        }

        return $this->render('user_profil/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //Delete User
    #[Route('/user/profil/{slug}/delete', name: 'app_user_profil_delete')]
    public function deleteUser(string $slug, UserProfilRepository $userRepository, EntityManagerInterface $em, SessionInterface $session, TokenStorageInterface $token, UploadFilesServices $uploadServices): Response
    {
        $user = $this->getUser();
        $userProfil = $userRepository->findOneBy(['slug' => $slug]);

        if ($user != $userProfil->getUser()) {
            return $this->redirectToRoute('app_user_profil_show', ['slug' => $userProfil->getSlug()]);
        } else if (!$userProfil) {
            return $this->redirectToRoute('app_home');
        }

        $uploadServices->deleteFileUpload($userProfil->getPicture());

        $em->remove($userProfil);
        $em->flush();

        $token->setToken(null);

        $session->invalidate();

        return $this->redirectToRoute('app_home');
    }
}
