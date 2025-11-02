<?php

namespace App\Controller;

use App\Entity\Enclo;
use App\Form\EncloType;
use App\Repository\EncloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/enclo')]
final class EncloController extends AbstractController
{
    #[Route(name: 'app_enclo_index', methods: ['GET'])]
    public function index(EncloRepository $encloRepository): Response
    {
        return $this->render('enclo/index.html.twig', [
            'enclos' => $encloRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_enclo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enclo = new Enclo();
        $form = $this->createForm(EncloType::class, $enclo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($enclo);
            $entityManager->flush();

            return $this->redirectToRoute('app_enclo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('enclo/new.html.twig', [
            'enclo' => $enclo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enclo_show', methods: ['GET'])]
    public function show(Enclo $enclo): Response
    {
        return $this->render('enclo/show.html.twig', [
            'enclo' => $enclo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_enclo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Enclo $enclo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EncloType::class, $enclo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_enclo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('enclo/edit.html.twig', [
            'enclo' => $enclo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enclo_delete', methods: ['POST'])]
    public function delete(Request $request, Enclo $enclo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enclo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($enclo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_enclo_index', [], Response::HTTP_SEE_OTHER);
    }
}
