<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Form\DeveloperType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeveloperController extends AbstractController
{
    #[Route('/developers/add', name: 'developer_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $developer = new Developer();
        $form = $this->createForm(DeveloperType::class, $developer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($developer);
            $entityManager->flush();

            return $this->redirectToRoute('developers_list');
        }

        return $this->render('developer/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/developers', name: 'developers_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $developers = $entityManager->getRepository(Developer::class)->findAll();

        return $this->render('developer/list.html.twig', [
            'developers' => $developers,
        ]);
    }

    #[Route('/developers/fire/{id}', name: 'developer_fire')]
    public function fire(int $id, EntityManagerInterface $entityManager): Response
    {
        $developer = $entityManager->getRepository(Developer::class)->find($id);

        if (!$developer) {
            throw $this->createNotFoundException('Developer not found');
        }

        $developer->setActive(false);
        $entityManager->flush();

        $this->addFlash('success', 'Developer has been successfully fired.');

        return $this->redirectToRoute('developers_list');
    }

    #[Route('/developers/transfer/{id}', name: 'developer_transfer')]
    public function transfer(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $developer = $entityManager->getRepository(Developer::class)->find($id);

        if (!$developer) {
            throw $this->createNotFoundException('Developer not found');
        }

        $form = $this->createForm(DeveloperType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('developers_list');
        }

        return $this->render('developer/transfer.html.twig', [
            'form' => $form->createView(),
            'developer' => $developer,
        ]);
    }
}
