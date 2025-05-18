<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518101230 extends AbstractMigration
{
   public function getDescription(): string
    {
        return 'Create table income';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE income (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            member_id INT UNSIGNED NOT NULL,
            amount NUMERIC(12, 2) NOT NULL,
            date DATE NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_INCOME_MEMBER FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_INCOME_MEMBER');
        $this->addSql('DROP TABLE income');
    }
}
