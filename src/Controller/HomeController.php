<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use App\Repository\EntrepriseProfilRepository;
use App\Repository\HomeSettingRepository;
use App\Repository\OfferRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntrepriseProfilRepository $entrepriseProfilRepository, HomeSettingRepository $homeSettingRepository, OfferRepository $offerRepository, TagRepository $tagRepository): Response
    {

        $setting = $homeSettingRepository->findAll();
        $offers = $offerRepository->findBy([], ['id' => 'DESC'], 6);
        $entreprises = $entrepriseProfilRepository->findBy([], ['id' => 'DESC'], 4);



        return $this->render('home/index.html.twig', [
            'setting' => $setting,
            'offers' => $offers,
            'entreprises' => $entreprises
        ]);
    }

    #[Route('/offre-emploi', name: 'app_offre_emploi')]
    public function offreEmploi(OfferRepository $offerRepository, TagRepository $tagRepository): Response
    {
        $offers = $offerRepository->findBy([], ['id' => 'DESC']);

        $tags = $tagRepository->findAll();

        return $this->render('home/offer_emploi.html.twig', [
            'offers' => $offers,
            'tag' => $tags
        ]);
    }

    #[Route('/offre-emploi/{slug}', name: 'app_offre_emploi_show')]
    public function offreEmploiShow($slug, Request $request, OfferRepository $offerRepository, ApplicationRepository $applicationRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $offer = $offerRepository->findOneBy(['slug' => $slug]);

        if (!$offer) {
            throw $this->createNotFoundException("L'offre demandée n'existe pas");
        }

        $entreprise = $offer->getEntreprise();

        $existingsApplication = $applicationRepository
            ->findOneBy(['Offer' => $offer, 'User' => $user, 'Entreprise' => $entreprise],);

        if ($existingsApplication) {
            notyf()
                ->position('x', 'right')
                ->position('y', 'top')
                ->addWarning('Vous avez déjà postulé à cette offre');
        }

        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $application->setUser($user);
            $application->setOffer($offer);
            $application->setCreatedAt(new \DateTimeImmutable());
            $application->setMessage($form->get('message')->getData());
            $application->setEntreprise($entreprise);
            $application->setStatus('STATUS_PENDING');
            $em->persist($application);
            $em->flush();
            notyf()
                ->position('x', 'right')
                ->position('y', 'top')
                ->addSuccess('Votre candidature a bien été envoyée');
            return $this->redirectToRoute('app_offre_emploi_show', ['slug' => $offer->getSlug()]);
        }


        return $this->render('home/offer_emploi_show.html.twig', [
            'offers' => $offer,
            'form' => $form->createView(),
            'existingsApplication' => $existingsApplication
        ]);
    }
}
