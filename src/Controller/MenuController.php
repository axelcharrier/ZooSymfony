<?php

namespace App\Controller;

use App\Repository\EncloRepository;
use App\Repository\EspaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Sodium\add;

final class MenuController extends AbstractController
{
    public function menu(EspaceRepository $espaceRepository, EncloRepository $encloRepository): Response
    {
        $espaces = $espaceRepository->findAll();
        $enclos = $encloRepository->findAll();


        return $this->render('menu/_menu.html.twig', [
            'espaces' => $espaces,
            'enclos' => $enclos,
        ]);
    }
}
