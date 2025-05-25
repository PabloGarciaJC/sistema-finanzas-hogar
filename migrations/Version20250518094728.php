<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250518094728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table credit';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE credit (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            user_id INT UNSIGNED NOT NULL,
            member_id INT UNSIGNED NOT NULL,
            bank_entity VARCHAR(255) NOT NULL,
            total_amount NUMERIC(12, 2) NOT NULL,
            frequency VARCHAR(20) NOT NULL,
            start_date DATE NOT NULL,
            monthly_payment NUMERIC(12, 2) NOT NULL,
            remaining_amount NUMERIC(12, 2) DEFAULT NULL,
            status VARCHAR(20) NOT NULL DEFAULT \'Active\',
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Relaciones foráneas
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_CREDIT_MEMBER FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_CREDIT_USER FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_CREDIT_USER');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_CREDIT_MEMBER');
        $this->addSql('DROP TABLE credit');
    }
}
