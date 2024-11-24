<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/projects/add', name: 'project_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $project = $form->getData();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('projects_list');
        }

        return $this->render('project/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/projects', name: 'projects_list')]
    public function getProjects(EntityManagerInterface $entityManager): Response
    {
        $projects = $entityManager->getRepository(Project::class)->findAll();

        return $this->render('projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/projects/close/{id}', name: 'project_close', methods: ['POST'])]
    public function close(int $id, EntityManagerInterface $entityManager): Response
    {
        $project = $entityManager->getRepository(Project::class)->find($id);

        if (!$project) {
            return $this->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        $project->setIsClosed(true); // Закрываем проект
        $entityManager->flush();

        return $this->redirectToRoute('projects_list');
    }
}
