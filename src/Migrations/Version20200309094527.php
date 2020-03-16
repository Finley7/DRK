<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200309094527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE warning (id INT AUTO_INCREMENT NOT NULL, receiver_id INT NOT NULL, author_id INT DEFAULT NULL, percentage INT NOT NULL, reason VARCHAR(255) NOT NULL, expires DATETIME NOT NULL, INDEX IDX_404E9CC6CD53EDB6 (receiver_id), INDEX IDX_404E9CC6F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ban (id INT AUTO_INCREMENT NOT NULL, receiver_id INT NOT NULL, author_id INT DEFAULT NULL, reason VARCHAR(255) NOT NULL, expires DATETIME NOT NULL, INDEX IDX_62FED0E5CD53EDB6 (receiver_id), INDEX IDX_62FED0E5F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE warning ADD CONSTRAINT FK_404E9CC6CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE warning ADD CONSTRAINT FK_404E9CC6F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ban ADD CONSTRAINT FK_62FED0E5CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ban ADD CONSTRAINT FK_62FED0E5F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE warning');
        $this->addSql('DROP TABLE ban');
    }
}
