<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250515102124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE credit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, member_id INT UNSIGNED NOT NULL, bank_entity VARCHAR(255) NOT NULL, total_amount NUMERIC(12, 2) NOT NULL, frequency VARCHAR(20) NOT NULL, start_date DATE NOT NULL, monthly_payment NUMERIC(12, 2) NOT NULL, remaining_amount NUMERIC(12, 2) DEFAULT NULL, status VARCHAR(20) DEFAULT 'Active' NOT NULL, INDEX IDX_1CC16EFE7597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE goal (id INT UNSIGNED AUTO_INCREMENT NOT NULL, member_id INT UNSIGNED NOT NULL, description LONGTEXT NOT NULL, target_amount NUMERIC(12, 2) NOT NULL, target_month VARCHAR(20) DEFAULT NULL, target_year INT DEFAULT NULL, status VARCHAR(20) DEFAULT 'In progress' NOT NULL, INDEX IDX_FCDCEB2E7597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE income (id INT UNSIGNED AUTO_INCREMENT NOT NULL, member_id INT UNSIGNED NOT NULL, amount NUMERIC(12, 2) NOT NULL, date DATE NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_3FA862D07597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `member` (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, salary NUMERIC(12, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE monthly_summary (id INT UNSIGNED AUTO_INCREMENT NOT NULL, member_id INT UNSIGNED NOT NULL, month VARCHAR(20) NOT NULL, year INT NOT NULL, total_income NUMERIC(12, 2) DEFAULT '0' NOT NULL, total_debt NUMERIC(12, 2) DEFAULT '0' NOT NULL, savings NUMERIC(12, 2) DEFAULT '0' NOT NULL, balance NUMERIC(12, 2) DEFAULT '0' NOT NULL, notes LONGTEXT DEFAULT NULL, INDEX IDX_C27DDDC87597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE period (id INT UNSIGNED AUTO_INCREMENT NOT NULL, month VARCHAR(20) NOT NULL, year INT NOT NULL, status VARCHAR(6) DEFAULT 'Open' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE saving (id INT UNSIGNED AUTO_INCREMENT NOT NULL, member_id INT UNSIGNED NOT NULL, month VARCHAR(20) NOT NULL, year INT NOT NULL, amount NUMERIC(12, 2) NOT NULL, INDEX IDX_B9DC3D0C7597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE7597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E7597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE income ADD CONSTRAINT FK_3FA862D07597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE monthly_summary ADD CONSTRAINT FK_C27DDDC87597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE saving ADD CONSTRAINT FK_B9DC3D0C7597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFE7597D3FE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E7597D3FE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE income DROP FOREIGN KEY FK_3FA862D07597D3FE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE monthly_summary DROP FOREIGN KEY FK_C27DDDC87597D3FE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE saving DROP FOREIGN KEY FK_B9DC3D0C7597D3FE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE credit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE goal
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE income
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `member`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE monthly_summary
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE period
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE saving
        SQL);
    }
}
