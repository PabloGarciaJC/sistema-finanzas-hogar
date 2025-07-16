<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250518101005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table goal';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE goal (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            user_id INT UNSIGNED NOT NULL,
            member_id INT UNSIGNED NOT NULL,
            amount NUMERIC(12, 2) NOT NULL,
            description TEXT NOT NULL,
            month INT NOT NULL,
            year INT NOT NULL,
            payment_day INT DEFAULT NULL,
            status TINYINT(1) NOT NULL DEFAULT 1,
            is_default TINYINT(1) NOT NULL DEFAULT 0,
            is_paid TINYINT(1) NOT NULL DEFAULT 0,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_GOAL_MEMBER FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_GOAL_USER FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }


    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_GOAL_USER');
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_GOAL_MEMBER');
        $this->addSql('DROP TABLE goal');
    }
}
