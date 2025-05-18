<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518094453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table member';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE member (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            company VARCHAR(255) DEFAULT NULL,
            salary NUMERIC(12, 2) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS member');
    }
}
