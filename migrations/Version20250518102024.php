<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518102024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table saving';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE saving (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            member_id INT UNSIGNED NOT NULL,
            month INT NOT NULL,
            year INT NOT NULL,
            amount NUMERIC(12, 2) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // Agregar la clave foránea
        $this->addSql('ALTER TABLE saving ADD CONSTRAINT FK_SAVING_MEMBER FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE saving DROP FOREIGN KEY FK_SAVING_MEMBER');
        $this->addSql('DROP TABLE saving');
    }
}
