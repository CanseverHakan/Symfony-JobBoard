<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Offer;
use App\Entity\UserProfil;
use App\Entity\HomeSetting;
use App\Entity\ContractType;
use App\Entity\EntrepriseProfil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $tabImage = [
            'https://source.unsplash.com/random/',
            'https://source.unsplash.com/user/wsanter',
            'https://source.unsplash.com/user/erondu',
            'https://source.unsplash.com/random/900×700/?fruit',
        ];

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i <= 5; $i++) {
            $homeSetting = new HomeSetting();
            $homeSetting->setImage($faker->randomElement($tabImage))
                ->setMessage($faker->paragraph())
                ->setCallToAction($faker->word());
            $manager->persist($homeSetting);
        }

        $tabTags = [
            'PHP',
            'Symfony',
            'Javascript',
            'React',
            'Angular',
            'VueJS',
            'NodeJS',
            'Python',
            'Java',
            'C#',
            'C++',
            'Ruby',
            'HTML',
            'CSS',
            'SQL',
            'NoSQL',
            'MongoDB',
            'MySQL',
            'PostgreSQL',
            'Oracle',
            'MariaDB',
            'SQLite',
            'Git',
            'GitHub',
            'GitLab',
            'BitBucket',
            'Docker',
            'Kubernetes',
            'Linux'
        ];

        foreach ($tabTags as $tag) {
            $tagEntity = new Tag();
            $tagEntity->setName($tag);
            $manager->persist($tagEntity);
        }

        $tabContractType = [
            'CDI',
            'CDD',
            'Freelance',
            'Stage',
            'Alternance',
            'Interim',
        ];

        foreach ($tabContractType as $contractType) {
            $contractTypeEntity = new ContractType();
            $contractTypeEntity->setName($contractType);
            $manager->persist($contractTypeEntity);
        }

        $faker = Factory::create('fr_FR');
        $tabRoles = ['Candidat', 'Professionnel'];

        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $userRandomRole = $faker->randomElement($tabRoles);
            $user->setEmail($faker->email());
            $user->setPassword(password_hash('password', PASSWORD_DEFAULT));
            $user->setStatus($userRandomRole);
            if ($userRandomRole == 'Professionnel') {
                $user->setUsername($faker->company());
                $user->setRoles(['ROLE_PRO']);
            } else {
                $user->setUsername($faker->name());
            }
            $manager->persist($user);
        }
        $manager->flush();

        //Insertion userProfil
        $userProfils = $manager->getRepository(User::class)->findByStatus('Candidat');

        foreach ($userProfils as $userProfil) {
            $profil = new UserProfil();
            $profil->setUser($userProfil);
            $profil->setFirstName($faker->firstName());
            $profil->setLastName($faker->lastName());
            $profil->setSlug($faker->slug());
            $profil->setAddress($faker->address());
            $profil->setCity($faker->city());
            $profil->setCountry($faker->country());
            $profil->setZipCode($faker->postcode());
            $profil->setPhoneNumber($faker->phoneNumber());
            $profil->setJobSought($faker->jobTitle());
            $profil->setPresentation($faker->paragraph(mt_rand(1, 3)));
            $profil->setAvailability($faker->boolean());
            $profil->setWebsite($faker->url());
            $profil->setPicture('https://api.dicebear.com/7.x/initials/svg?seed=' . $userProfil->getUserName());
            $manager->persist($profil);
        }

        $user = new User();
        $user->setEmail('hakan@hakan.com');
        $user->setPassword(password_hash('pikachu', PASSWORD_DEFAULT));
        $user->setStatus('Admin');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setUsername('Hakan Admin');
        $user->setIsVerified(true);
        $manager->persist($user);
        $manager->flush();


        $entrepriseProfils = $manager->getRepository(User::class)->findByStatus('Professionnel');

        foreach ($entrepriseProfils as $entrepriseProfil) {
            $eProfil = new EntrepriseProfil();
            $eProfil->setUser($entrepriseProfil);
            $eProfil->setName($faker->name());
            $eProfil->setSlug($faker->slug());
            $eProfil->setAddress($faker->address());
            $eProfil->setCity($faker->city());
            $eProfil->setCountry($faker->country());
            $eProfil->setZipCode($faker->postcode());
            $eProfil->setPhoneNumber($faker->phoneNumber());
            $eProfil->setEmail($faker->email());
            $eProfil->setActivityArea($faker->jobTitle());
            $eProfil->setDescription($faker->paragraph(mt_rand(1, 20)));
            $eProfil->setWebsite($faker->url());
            $eProfil->setLogo('https://api.dicebear.com/7.x/initials/svg?seed=' . $eProfil->getName());
            $manager->persist($eProfil);
        }

        $manager->flush();

        $recruteurs = $manager->getRepository(EntrepriseProfil::class)->findAll();
        $tags = $manager->getRepository(Tag::class)->findAll();
        $contractTypes = $manager->getRepository(ContractType::class)->findAll();


        for ($i = 0; $i <= 100; $i++) {
            $offer = new Offer();
            $offer->setTitle($faker->jobTitle());
            $offer->setShortDescription($faker->word(mt_rand(100, 255)));
            $offer->setContent($faker->paragraph(mt_rand(3, 6)));
            $offer->setSalary(mt_rand(30000, 100000));
            $offer->setLocation($faker->city());
            $offer->setContractType($faker->randomElement($contractTypes));
            $offer->setSlug($faker->slug());
            $offer->setEntreprise($faker->randomElement($recruteurs));
            $randomTags = $faker->randomElements($tags, mt_rand(3, 8));

            foreach ($randomTags as $tag) {
                $offer->addTag($tag);
            }
            $manager->persist($offer);
        }

        $manager->flush();
    }
}
