<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250518094452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table user for authentication with role_id and status';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user (
        id INT UNSIGNED AUTO_INCREMENT NOT NULL,
        email VARCHAR(180) NOT NULL UNIQUE,
        alias VARCHAR(255) DEFAULT NULL,
        roles JSON NOT NULL,
        password VARCHAR(255) NOT NULL,
        status TINYINT(1) NOT NULL DEFAULT 0,
        PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
    }
}
