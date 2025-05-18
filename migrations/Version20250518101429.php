<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518101429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table monthly_summary';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE monthly_summary (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            member_id INT UNSIGNED NOT NULL,
            month INT NOT NULL,
            year INT NOT NULL,
            total_income NUMERIC(12, 2) NOT NULL,
            total_debt NUMERIC(12, 2) NOT NULL,
            savings NUMERIC(12, 2) NOT NULL,
            balance NUMERIC(12, 2) NOT NULL,
            notes TEXT DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE monthly_summary ADD CONSTRAINT FK_MONTHLYSUMMARY_MEMBER FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE monthly_summary DROP FOREIGN KEY FK_MONTHLYSUMMARY_MEMBER');
        $this->addSql('DROP TABLE monthly_summary');
    }
}
