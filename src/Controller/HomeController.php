<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    
    #[Route('/', name: 'root')]
    public function redirectToHome(): Response
    {
        return $this->redirectToRoute('app_home');
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/sevicos-opcoes', name: 'app_servicos_opcoes')]
    public function servicosOpcoes(): Response
    {
        return $this->render('home/servicos-opcoes.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/error', name: 'app_error')]
    public function handleError(\Throwable $exception): Response
    {
        if ($exception instanceof NotFoundHttpException) {
            return $this->redirectToRoute('app_home'); // redireciona para a home em caso de 404
        }

        // Outros tratamentos de erro podem ser adicionados aqui
        return $this->redirectToRoute('app_home');
    }
}
