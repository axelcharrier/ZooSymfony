<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Enclo;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use App\Repository\EncloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/animal')]
final class AnimalController extends AbstractController
{
    #[Route(name: 'app_animal_index', methods: ['GET'])]
    public function index(AnimalRepository $animalRepository): Response
    {
        return $this->render('animal/index.html.twig', [
            'animals' => $animalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_animal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, EncloRepository $enclo, AnimalRepository $animaux): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        $errorMessage = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $dateNaissance = $animal->getDateNaissance();
            $dateArrive = $animal->getDateArrive();
            $dateDepart = $animal->getDateDepart();
            $genre = $animal->getGenre();
            $sterilise = $animal->isSterilise();

            $occupationActuelle = count($animaux->findBy(['id_enclo' => $animal->getIdEnclo()]));
            $capacityEnclo = $enclo->find($animal->getIdEnclo())->getCapacite();


            if (($dateNaissance && $dateArrive && $dateNaissance > $dateArrive) || ($dateDepart && $dateArrive && $dateDepart < $dateArrive) || ($sterilise && $genre == "non définie") || ($capacityEnclo-1 < $occupationActuelle)) {
                $errorMessage = "Erreur lors de la création de l'animal";
            } else {
                $entityManager->persist($animal);
                $entityManager->flush();

                return $this->redirectToRoute('app_animal_index');
            }
        }

        return $this->render('animal/new.html.twig', [
            'animal' => $animal,
            'form' => $form,
            'message' => $errorMessage,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_show', methods: ['GET'])]
    public function show(Animal $animal): Response
    {
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Animal $animal, EntityManagerInterface $entityManager, EncloRepository $enclo, AnimalRepository $animaux): Response
    {
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);
        $errorMessage = null;

        $occupationActuelle = count($animaux->findBy(['id_enclo' => $animal->getIdEnclo()]));
        $capacityEnclo = $enclo->find($animal->getIdEnclo())->getCapacite();

        if ($form->isSubmitted() && $form->isValid()) {
            $dateNaissance = $animal->getDateNaissance();
            $dateArrive = $animal->getDateArrive();
            $dateDepart = $animal->getDateDepart();
            $genre = $animal->getGenre();
            $sterilise = $animal->isSterilise();



            if (($dateNaissance && $dateArrive && $dateNaissance > $dateArrive) || ($dateDepart && $dateArrive && $dateDepart < $dateArrive) || ($sterilise && $genre == "non définie") || ($capacityEnclo < $occupationActuelle)) {
                $errorMessage = "Erreur lors de la modification de l'animal.";
            } else {
                $entityManager->flush();
                return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('animal/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
            'message' => $errorMessage,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_delete', methods: ['POST'])]
    public function delete(Request $request, Animal $animal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $animal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($animal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    }

    public function check_enclo_capacity(int $id_enclo): Response
    {
        $nombre_animaux = $animal();
    }
}
