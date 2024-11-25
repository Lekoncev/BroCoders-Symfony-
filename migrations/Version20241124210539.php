<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241124210539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE developer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, birthdate DATE DEFAULT NULL, position VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_closed TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developers_projects (project_id INT NOT NULL, developer_id INT NOT NULL, INDEX IDX_23A8596B166D1F9C (project_id), INDEX IDX_23A8596B64DD9267 (developer_id), PRIMARY KEY(project_id, developer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE developers_projects ADD CONSTRAINT FK_23A8596B166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developers_projects ADD CONSTRAINT FK_23A8596B64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developers_projects DROP FOREIGN KEY FK_23A8596B166D1F9C');
        $this->addSql('ALTER TABLE developers_projects DROP FOREIGN KEY FK_23A8596B64DD9267');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE developers_projects');
    }
}
