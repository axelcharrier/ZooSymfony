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

final class AnimalController extends AbstractController
{
    #[Route("/animal/", name: 'app_animal_index', methods: ['GET'])]
    public function index(AnimalRepository $animalRepository): Response
    {
        return $this->render('animal/index.html.twig', [
            'animals' => $animalRepository->findAll(),
        ]);
    }

    #[Route('/animal/new', name: 'app_animal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, EncloRepository $enclo, AnimalRepository $animaux): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $dateNaissance = $animal->getDateNaissance();
            $dateArrive = $animal->getDateArrive();
            $dateDepart = $animal->getDateDepart();
            $genre = $animal->getGenre();
            $sterilise = $animal->isSterilise();

            $occupationActuelle = count($animaux->findBy(['id_enclo' => $animal->getIdEnclo()]));
            $capacityEnclo = $enclo->find($animal->getIdEnclo())->getCapacite();


            if (($dateNaissance && $dateArrive && $dateNaissance > $dateArrive) || ($dateDepart && $dateArrive && $dateDepart < $dateArrive) || ($sterilise && $genre == "non définie") || ($capacityEnclo-1 < $occupationActuelle)) {
                $this->addFlash("error", "Erreur lors de la modification de l'animal, vérifiez les données entrées");
                return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);

            } else {
                $entityManager->persist($animal);
                $entityManager->flush();

                return $this->redirectToRoute('app_enclo_show', ['id'=>$animal->getIdEnclo()->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('animal/new.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('animal/{id}', name: 'app_animal_show', methods: ['GET'])]
    public function show(Animal $animal): Response
    {
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
        ]);
    }

    #[Route('/animal/{id}/edit', name: 'app_animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Animal $animal, EntityManagerInterface $entityManager, EncloRepository $enclo, AnimalRepository $animaux): Response
    {
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        $occupationActuelle = count($animaux->findBy(['id_enclo' => $animal->getIdEnclo()]));
        $capacityEnclo = $enclo->find($animal->getIdEnclo())->getCapacite();

        if ($form->isSubmitted() && $form->isValid()) {
            $dateNaissance = $animal->getDateNaissance();
            $dateArrive = $animal->getDateArrive();
            $dateDepart = $animal->getDateDepart();
            $genre = $animal->getGenre();
            $sterilise = $animal->isSterilise();
            $verifId = strlen(strval($animal->getId())) ;

            if (($dateNaissance && $dateArrive && $dateNaissance > $dateArrive) || ($dateDepart && $dateArrive && $dateDepart < $dateArrive) || ($sterilise && $genre == "non définie") || ($capacityEnclo < $occupationActuelle) || ($verifId == 13)) {
                $this->addFlash("error", "Erreur lors de la modification de l'animal, vérifiez les données entrées");
                return $this->render('animal/edit.html.twig', [
                    'animal' => $animal,
                    'form' => $form,
                ]);
            } else {
                $entityManager->flush();
                return $this->redirectToRoute('app_enclo_show', ['id'=>$animal->getIdEnclo()->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('animal/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('animal/{id}/delete', name: 'app_animal_delete', methods: ['POST'])]
    public function delete(Request $request, Animal $animal, EntityManagerInterface $entityManager): Response
    {
        $id = $animal->getIdEnclo()->getId();
        if ($this->isCsrfTokenValid('delete' . $animal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($animal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_enclo_show', ["id"=>$id], Response::HTTP_SEE_OTHER);
    }
}
