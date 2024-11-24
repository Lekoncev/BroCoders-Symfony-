<?php

namespace App\Controller;

use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MigrationController extends AbstractController
{
    private $diffCommand;

    public function __construct(DiffCommand $diffCommand)
    {
        $this->diffCommand = $diffCommand;
    }

    #[Route('/create-migration', name: 'create_migration', methods: ['POST', 'GET'])]
    public function createMigration(Request $request): Response
    {
        $output = '';

        if ($request->isMethod('POST')) {
            $outputBuffer = new BufferedOutput();
            $input = new ArrayInput([]);

            // Выполнение команды создания миграции
            $statusCode = $this->diffCommand->run($input, $outputBuffer);

            $output = $outputBuffer->fetch();

            if ($statusCode !== 0) {
                return new Response('Ошибка при создании миграции: ' . $output, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $output = 'Миграция успешно создана!<br>' . nl2br(htmlspecialchars($output));
        }

        return $this->render('migration/create.html.twig', [
            'output' => $output,
        ]);
    }

    #[Route('/apply-migration', name: 'apply_migration', methods: ['POST', 'GET'])]
    public function applyMigration(Request $request): Response
    {
        $output = '';

        if ($request->isMethod('POST')) {
            $outputBuffer = new BufferedOutput();
            $input = new ArrayInput(['--no-interaction' => true]);

            // Получаем команду миграции из контейнера
            $migrateCommand = $this->container->get('doctrine_migrations.migrate_command');

            // Выполнение команды применения миграций
            $statusCode = $migrateCommand->run($input, $outputBuffer);

            $output = $outputBuffer->fetch();

            if ($statusCode !== 0) {
                return new Response('Ошибка при применении миграции: ' . $output, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $output = 'Миграции успешно применены!<br>' . nl2br(htmlspecialchars($output));
        }

        return $this->render('migration/apply.html.twig', [
            'output' => $output,
        ]);
    }
}
