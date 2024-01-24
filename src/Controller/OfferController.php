<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\ApplicationRepository;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/account')]
class OfferController extends AbstractController
{
    #[Route('/offer', name: 'app_offer')]
    public function index(OfferRepository $offerRepository): Response
    {

        $user = $this->getUser();

        $company = $user->getEntrepriseProfil();

        if (!$company) {
            return $this->redirectToRoute('app_entreprise_profil');
        }

        $Offers = $offerRepository->findByEntreprise($company);

        return $this->render('offer/index.html.twig', [
            'offers' => $Offers,
        ]);
    }


    #[Route('/entreprise/offer/new', name: 'app_offer_create')]
    public function createNewOffer(Request $request, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();
        $company = $user->getEntrepriseProfil();
        if (!$company) {
            return $this->redirectToRoute('app_entreprise_profil');
        }

        $offer = new Offer();

        $form = $this->createForm(OfferType::class, $offer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer->setEntreprise($company);

            $em->persist($offer);
            $em->flush();

            notyf()
                ->position('x', 'right')
                ->position('y', 'top')
                ->duration(5000)
                ->addSuccess('Votre offre a bien été créée.');

            return $this->redirectToRoute('app_offer');
        }

        return $this->render('offer/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/entreprise/offer/{slug}/delete', name: 'app_offer_delete')]
    public function deleteOffer(string $slug, OfferRepository $offerRepository, EntityManagerInterface $em,)
    {

        $user = $this->getUser();
        $company = $user->getEntrepriseProfil();

        if (!$company) {
            return $this->redirectToRoute('app_entreprise_profil');
        }

        $offer = $offerRepository->findOneBy(['slug' => $slug]);

        if (!$offer) {
            return $this->redirectToRoute('app_offer');
        }

        if ($offer->getEntreprise() !== $company) {
            return $this->redirectToRoute('app_offer');
        }      

        $em->remove($offer);
        $em->flush();

        notyf()
            ->position('x', 'right')
            ->position('y', 'top')
            ->duration(5000)
            ->addSuccess('Votre offre a bien été supprimée.');

        return $this->redirectToRoute('app_offer');
    }

    #[Route('/entreprise/offer/{slug}/edit', name: 'app_offer_edit')]
    public function editOffer(string $slug, OfferRepository $offerRepository, EntityManagerInterface $em, Request $request)
    {
        $user = $this->getUser();
        $company = $user->getEntrepriseProfil();

        if (!$company) {
            return $this->redirectToRoute('app_entreprise_profil');
        }

        $offer = $offerRepository->findOneBy(['slug' => $slug]);

        if (!$offer) {
            return $this->redirectToRoute('app_offer');
        }

        if ($offer->getEntreprise() !== $company) {
            return $this->redirectToRoute('app_offer');
        }

        $offer = $offerRepository->findOneBy(['slug' => $slug]);

        $form = $this->createForm(OfferType::class, $offer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            notyf()
                ->position('x', 'right')
                ->position('y', 'top')
                ->duration(5000)
                ->addSuccess('Votre offre a bien été modifiée.');

            return $this->redirectToRoute('app_offer');
        }

        return $this->render('offer/edit.html.twig', [
            'form' => $form->createView(),
            'offer' => $offer,
        ]);
    }

    #[Route('/entreprise/offer/{slug}', name: 'app_offer_show')]
    public function showOffer(string $slug, OfferRepository $offerRepository, ApplicationRepository $applicationRepository)
    {
        $user = $this->getUser();
        $company = $user->getEntrepriseProfil();

        if (!$company) {
            return $this->redirectToRoute('app_entreprise_profil');
        }

        $offer = $offerRepository->findOneBy(['slug' => $slug]);

        if (!$offer) {
            return $this->redirectToRoute('app_offer');
        }

        if ($offer->getEntreprise() !== $company) {
            return $this->redirectToRoute('app_offer');
        }

        //Recuperation Candidat
        $applications = $applicationRepository->findBy(['Offer' => $offer]);


        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
            'applications' => $applications
        ]);
    }

    // #[Route('/entreprise/offer/{slug}/candidate/{id}', name: 'app_offer_candidate')]
    // public function getCandidate(string $id, string $slug, Request $request, EntityManagerInterface $em,  OfferRepository $offerRepository, ApplicationRepository $applicationRepository): Response
    // {
    //     $offer = $offerRepository->findOneBy(['slug' => $slug]);

    //     $candidate = $applicationRepository->findOneBy(['id' => $id]);

    //     $form = $this->createForm(ApplyStatusType::class, $candidate);

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {

    //         $em->flush();

    //         notyf()
    //             ->position('x', 'right')
    //             ->position('y', 'top')
    //             ->addSuccess('La candidature a bien été modifiée.');

    //         return $this->redirectToRoute('app_offer_show', ['slug' => $offer->getSlug()]);
    //     }

    //     return $this->render(
    //         'entreprise_profil/offer/candidate.html.twig',
    //         [
    //             'candidate' => $candidate,
    //             'statusForm' => $form->createView()
    //         ]
    //     );
    // }
}
