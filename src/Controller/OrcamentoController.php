<?php

namespace App\Controller;

use App\Entity\Orcamento;
use App\Entity\Cliente;
use App\Entity\Servico;
use App\Form\OrcamentoType;
use App\Repository\OrcamentoRepository;
use App\Form\OrcamentoCompletoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/orcamento')]
final class OrcamentoController extends AbstractController
{
    #[Route(name: 'app_orcamento_index', methods: ['GET'])]
    public function index(OrcamentoRepository $orcamentoRepository): Response
    {
        return $this->render('orcamento/index.html.twig', [
            'orcamentos' => $orcamentoRepository->findAll(),
        ]);
    }

    #[Route('/novo', name: 'orcamento_novo')]
    public function novo(Request $request, EntityManagerInterface $em): Response
    {
        $orcamento = new Orcamento();

        $form = $this->createForm(OrcamentoCompletoType::class, $orcamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Criar novo cliente
            $cliente = new Cliente();
            $cliente->setNome($form->get('nomeCliente')->getData());
            $cliente->setContato($form->get('contatoCliente')->getData());

            $em->persist($cliente);
            $em->flush();

            // Associar cliente e serviço ao orçamento
            $orcamento->setIdCliente($cliente);
            // Processar o ID do serviço manualmente
            $servicoId = $request->request->get('id_servico'); // Recebe o ID do select manual
            $servico = $em->getRepository(Servico::class)->find($servicoId);

            if (!$servico) {
                throw $this->createNotFoundException('Serviço não encontrado.');
            }


            $valorUnid = $orcamento->getIdServico()->getValorUnid();
            $orcamento->setValorTotal($valorUnid * $orcamento->getQtd());

            $em->persist($orcamento);
            $em->flush();

            $this->addFlash('success', 'Orçamento e cliente cadastrados com sucesso!');

            return $this->redirectToRoute('orcamento_novo');
        }

        return $this->render('orcamento/novo.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/new', name: 'app_orcamento_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $orcamento = new Orcamento();
        $form = $this->createForm(OrcamentoType::class, $orcamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($orcamento);
            $entityManager->flush();

            return $this->redirectToRoute('app_orcamento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orcamento/new.html.twig', [
            'orcamento' => $orcamento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orcamento_show', methods: ['GET'])]
    public function show(Orcamento $orcamento): Response
    {
        return $this->render('orcamento/show.html.twig', [
            'orcamento' => $orcamento,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_orcamento_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orcamento $orcamento, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrcamentoType::class, $orcamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_orcamento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orcamento/edit.html.twig', [
            'orcamento' => $orcamento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orcamento_delete', methods: ['POST'])]
    public function delete(Request $request, Orcamento $orcamento, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orcamento->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($orcamento);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_orcamento_index', [], Response::HTTP_SEE_OTHER);
    }
}
