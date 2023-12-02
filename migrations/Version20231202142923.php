<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202142923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, sender_account_id_id INT NOT NULL, receiver_account_id_id INT NOT NULL, transaction_id INT NOT NULL, sent_amount VARCHAR(255) NOT NULL, received_amount VARCHAR(255) NOT NULL, INDEX IDX_723705D11E517582 (sender_account_id_id), INDEX IDX_723705D150542ADD (receiver_account_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D11E517582 FOREIGN KEY (sender_account_id_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D150542ADD FOREIGN KEY (receiver_account_id_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D11E517582');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D150542ADD');
        $this->addSql('DROP TABLE transaction');
    }
}
