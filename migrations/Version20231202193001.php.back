<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202193001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, sender_account_id INT NOT NULL, receiver_account_id INT NOT NULL, transaction_amount DOUBLE PRECISION NOT NULL, currency VARCHAR(3) NOT NULL, INDEX IDX_723705D1CFEF0177 (sender_account_id), INDEX IDX_723705D1D8CF5973 (receiver_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1CFEF0177 FOREIGN KEY (sender_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D8CF5973 FOREIGN KEY (receiver_account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1CFEF0177');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1D8CF5973');
        $this->addSql('DROP TABLE transaction');
    }
}
