<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\Project;
use App\Form\DeveloperType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeveloperController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Метод для получения списка проектов
    private function getProjects(): array
    {
        return $this->entityManager->getRepository(Project::class)->findAll();
    }

    #[Route('/developers/add', name: 'developer_add')]
    public function add(Request $request): Response
    {
        $developer = new Developer();
        $projects = $this->getProjects();
        $form = $this->createForm(DeveloperType::class, $developer, [
            'projects' => $projects,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($developer);
            $this->entityManager->flush();

            $this->addFlash('success', 'Разработчик успешно добавлен.');

            return $this->redirectToRoute('developers_list');
        }

        return $this->render('developer/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/developers', name: 'developers_list')]
    public function list(): Response
    {
        $developers = $this->entityManager->getRepository(Developer::class)->findAll();

        return $this->render('developer/list.html.twig', [
            'developers' => $developers,
        ]);
    }

    #[Route('/developers/fire/{id}', name: 'developer_fire')]
    public function fire(int $id): Response
    {
        $developer = $this->entityManager->getRepository(Developer::class)->find($id);

        if (!$developer) {
            throw $this->createNotFoundException('Разработчик не найден');
        }

        $developer->setActive(false);
        $this->entityManager->flush();

        $this->addFlash('success', 'Разработчик был успешно уволен.');

        return $this->redirectToRoute('developers_list');
    }

    #[Route('/developers/edit/{id}', name: 'developer_edit')]
    public function edit(int $id, Request $request): Response
    {
        $developer = $this->entityManager->getRepository(Developer::class)->find($id);

        if (!$developer) {
            throw $this->createNotFoundException('Разработчик не найден');
        }

        $projects = $this->getProjects();
        $form = $this->createForm(DeveloperType::class, $developer, [
            'projects' => $projects,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Данные разработчика успешно обновлены.');

            return $this->redirectToRoute('developers_list');
        } else {
            // Отладка: вывод ошибок валидации
            foreach ($form->getErrors(true) as $error) {
                dump($error->getMessage());
            }
        }

        return $this->render('developer/edit.html.twig', [
            'form' => $form->createView(),
            'developer' => $developer,
        ]);
    }

    #[Route('/developers/transfer/{id}', name: 'developer_transfer')]
    public function transfer(int $id, Request $request): Response
    {
        $developer = $this->entityManager->getRepository(Developer::class)->find($id);

        if (!$developer) {
            throw $this->createNotFoundException('Разработчик не найден');
        }

        // Получаем список проектов
        $projects = $this->getProjects();

        // Создаем форму для перемещения разработчика между проектами
        $form = $this->createForm(DeveloperType::class, $developer, [
            'projects' => $projects,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Логика перемещения между проектами
            $this->entityManager->flush();
            $this->addFlash('success', 'Разработчик успешно перенесен.');

            return $this->redirectToRoute('developers_list');
        }

        return $this->render('developer/transfer.html.twig', [
            'form' => $form->createView(),
            'developer' => $developer,
        ]);
    }
}
