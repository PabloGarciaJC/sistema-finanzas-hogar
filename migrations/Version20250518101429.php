<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250518101429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table monthly summary';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE monthly_summary (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            user_id INT UNSIGNED NOT NULL,
            month INT NOT NULL,
            year INT NOT NULL,
            total_income NUMERIC(12, 2) NOT NULL,
            savings NUMERIC(12, 2) NOT NULL,
            debt_total NUMERIC(12, 2) NOT NULL,
            bank_balance JSON NOT NULL,
            services JSON NOT NULL,
            cash_payment JSON NOT NULL,
            credit JSON NOT NULL,
            goal JSON NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE monthly_summary ADD CONSTRAINT FK_MONTHLY_SUMMARY_USER FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE monthly_summary DROP FOREIGN KEY FK_MONTHLY_SUMMARY_USER');
        $this->addSql('DROP TABLE monthly_summary');
    }
}
