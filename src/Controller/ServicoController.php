<?php

namespace App\Controller;

use App\Entity\Servico;
use App\Form\ServicoType;
use App\Repository\ServicoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/servico')]
final class ServicoController extends AbstractController
{
    #[Route( '/' , name: 'app_servico_index', methods: ['GET'])]
    public function index(ServicoRepository $servicoRepository): Response
    {
        return $this->render('servico/index.html.twig', [
            'servicos' => $servicoRepository->findAll(),
        ]);
    }

    #[Route('/api/listar', name: 'api_listar', methods: ['GET'])]
    public function listar(ServicoRepository $servicoRepository): JsonResponse
    {
        $servicos = $servicoRepository->findAll();

        $data = [];
        foreach ($servicos as $servico) {
            $data[] = [
                'id' => $servico->getId(),
                'tipo' => $servico->getTipo(),
                'valorUnid' => $servico->getValorUnid(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/new', name: 'app_servico_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $servico = new Servico();
        $form = $this->createForm(ServicoType::class, $servico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($servico);
            $entityManager->flush();

            return $this->redirectToRoute('app_servico_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('servico/new.html.twig', [
            'servico' => $servico,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_servico_show', methods: ['GET'])]
    public function show(Servico $servico): Response
    {
        return $this->render('servico/show.html.twig', [
            'servico' => $servico,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_servico_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Servico $servico, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServicoType::class, $servico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_servico_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('servico/edit.html.twig', [
            'servico' => $servico,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_servico_delete', methods: ['POST'])]
    public function delete(Request $request, Servico $servico, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$servico->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($servico);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_servico_index', [], Response::HTTP_SEE_OTHER);
    }
}
