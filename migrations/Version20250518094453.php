<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

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
            user_id INT UNSIGNED NOT NULL,
            name VARCHAR(255) NOT NULL,
            company VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_MEMBER_USER FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_MEMBER_USER');
        $this->addSql('DROP TABLE IF EXISTS member');
    }
}
