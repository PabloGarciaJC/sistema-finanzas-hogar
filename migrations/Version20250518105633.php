<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250518105633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table services';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE services (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            user_id INT UNSIGNED NOT NULL,
            member_id INT UNSIGNED NOT NULL,
            amount NUMERIC(12, 2) NOT NULL,
            description TEXT NOT NULL,
            status VARCHAR(20) NOT NULL DEFAULT \'Active\',
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_SERVICES_MEMBER FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_SERVICES_USER FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_SERVICES_USER');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_SERVICES_MEMBER');
        $this->addSql('DROP TABLE services');
    }
}
