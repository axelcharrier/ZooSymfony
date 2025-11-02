<?php

namespace App\Controller;

use App\Entity\Espace;
use App\Form\EspaceType;
use App\Repository\EspaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/espace')]
final class EspaceController extends AbstractController
{
    #[Route(name: 'app_espace_index', methods: ['GET'])]
    public function index(EspaceRepository $espaceRepository): Response
    {
        return $this->render('espace/index.html.twig', [
            'espaces' => $espaceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_espace_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $espace = new Espace();
        $form = $this->createForm(EspaceType::class, $espace);
        $form->handleRequest($request);

        $errorMessage = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $dateOuverture = $espace->getDateOuverture();
            $dateFermeture = $espace->getDateFermeture();

            if (($dateFermeture && $dateOuverture && $dateFermeture > $dateOuverture) || ($dateFermeture && !$dateOuverture)) {
                $errorMessage = "Erreur lors de la création de l'espace";
            } else {

                $entityManager->persist($espace);
                $entityManager->flush();

                return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('espace/new.html.twig', [
            'espace' => $espace,
            'form' => $form,
            'message' => $errorMessage,
        ]);
    }

    #[Route('/{id}', name: 'app_espace_show', methods: ['GET'])]
    public function show(Espace $espace): Response
    {
        return $this->render('espace/show.html.twig', [
            'espace' => $espace,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_espace_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Espace $espace, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EspaceType::class, $espace);
        $form->handleRequest($request);
        $errorMessage = null;


        if ($form->isSubmitted() && $form->isValid()) {
            $dateOuverture = $espace->getDateOuverture();
            $dateFermeture = $espace->getDateFermeture();


            if (($dateFermeture && $dateOuverture && $dateFermeture < $dateOuverture) || ($dateFermeture && !$dateOuverture)) {
                $errorMessage = "Erreur lors de la modification de l'espace";
            } else {
                $entityManager->flush();

                return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('espace/edit.html.twig', [
            'espace' => $espace,
            'form' => $form,
            'message' => $errorMessage,
        ]);
    }

    #[Route('/{id}', name: 'app_espace_delete', methods: ['POST'])]
    public function delete(Request $request, Espace $espace, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$espace->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($espace);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_espace_index', [], Response::HTTP_SEE_OTHER);
    }
}
