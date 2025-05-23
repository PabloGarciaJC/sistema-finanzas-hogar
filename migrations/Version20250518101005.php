<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518101005 extends AbstractMigration
{
       public function getDescription(): string
    {
        return 'Create table goal';
    }

    public function up(Schema $schema): void
    {
        // Crear la tabla goal
        $this->addSql('CREATE TABLE goal (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            member_id INT UNSIGNED NOT NULL,
            description TEXT NOT NULL,
            target_amount NUMERIC(12, 2) NOT NULL,
            frequency VARCHAR(20) NOT NULL,
            start_date DATE NOT NULL,
            status VARCHAR(20) NOT NULL DEFAULT \'In progress\',
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // Agregar la clave foránea
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_GOAL_MEMBER FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // Eliminar la clave foránea
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_GOAL_MEMBER');
        // Eliminar la tabla goal
        $this->addSql('DROP TABLE goal');
    }
}
