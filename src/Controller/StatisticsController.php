<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Developer;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws Exception
     */
    #[Route('/statistics', name: 'statistics')]
    public function index(): Response
    {
        // Количество проектов
        $totalProjects = $this->entityManager->getRepository(Project::class)->count([]);

        // Количество сотрудников
        $totalDevelopers = $this->entityManager->getRepository(Developer::class)->count([]);

        // Средний возраст сотрудников через SQL-запрос
        $averageAge = $this->entityManager->getConnection()->executeQuery('
         SELECT COALESCE(AVG(YEAR(CURDATE()) - YEAR(STR_TO_DATE(birthdate, "%d.%m.%Y"))), 0) AS average_age FROM developer
        ')->fetchOne();

        // Проверка и обработка результата
        if ($averageAge === null) {
            $averageAge = 0;
        }

        // Округление до одного знака после запятой
        $averageAge = round($averageAge, 1);

        // Количество сотрудников по проектам
        $projectsWithDeveloperCount = $this->entityManager->createQuery('
            SELECT p.name AS project_name, COUNT(d.id) AS developer_count
            FROM App\Entity\Project p
            LEFT JOIN p.developers d
            GROUP BY p.id
        ')->getResult();

        // Количество закрытых и открытых проектов
        $closedProjects = $this->entityManager->createQuery('SELECT COUNT(p.id) FROM App\Entity\Project p WHERE p.isClosed = true')->getSingleScalarResult();
        $openProjects = $this->entityManager->createQuery('SELECT COUNT(p.id) FROM App\Entity\Project p WHERE p.isClosed = false')->getSingleScalarResult();

        return $this->render('statistics.html.twig', [
            'total_projects' => $totalProjects,
            'total_developers' => $totalDevelopers,
            'average_age' => $averageAge,
            'projects_with_developer_count' => $projectsWithDeveloperCount,
            'closed_projects' => $closedProjects,
            'open_projects' => $openProjects,
        ]);
    }
}