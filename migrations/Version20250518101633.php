<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518101633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table period';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE period (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            month INT NOT NULL,
            year INT NOT NULL,
            status VARCHAR(20) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE period');
    }
}
