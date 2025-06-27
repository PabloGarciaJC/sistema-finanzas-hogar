<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250627121500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table currency';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE currency (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            code VARCHAR(3) NOT NULL,
            name VARCHAR(50) NOT NULL,
            symbol VARCHAR(5) NOT NULL,
             status TINYINT(1) NOT NULL DEFAULT 0,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE currency');
    }
}
