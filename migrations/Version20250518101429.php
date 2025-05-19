<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250518101429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table monthly_summary (sin relación con member)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE monthly_summary (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            month INT NOT NULL,
            year INT NOT NULL,
            total_income NUMERIC(12, 2) NOT NULL,
            savings NUMERIC(12, 2) NOT NULL,
            bank_debt_menber_one NUMERIC(12, 2) NOT NULL,
            bank_debt_member_two NUMERIC(12, 2) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE monthly_summary');
    }
}
