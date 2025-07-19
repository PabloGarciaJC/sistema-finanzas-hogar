<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250529163611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table configuration';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE configuration (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            year INT NOT NULL,
            currency VARCHAR(3) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE configuration');
    }
}
