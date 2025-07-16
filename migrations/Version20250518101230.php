<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

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
            user_id INT UNSIGNED NOT NULL,
            member_id INT UNSIGNED NOT NULL,
            amount NUMERIC(12, 2) NOT NULL,
            month INT NOT NULL,
            year INT NOT NULL,
            status TINYINT(1) NOT NULL DEFAULT 1,
            is_default TINYINT(1) NOT NULL DEFAULT 0,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_INCOME_MEMBER FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_INCOME_USER FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_INCOME_USER');
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_INCOME_MEMBER');
        $this->addSql('DROP TABLE income');
    }
}
