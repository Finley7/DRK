<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200308114008 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, min_role_id INT DEFAULT NULL, category_id INT NOT NULL, subforum_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, INDEX IDX_852BBECD8EFD03E7 (min_role_id), INDEX IDX_852BBECD12469DE2 (category_id), INDEX IDX_852BBECD225C0759 (subforum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECD8EFD03E7 FOREIGN KEY (min_role_id) REFERENCES user_role (id)');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECD225C0759 FOREIGN KEY (subforum_id) REFERENCES forum (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECD225C0759');
        $this->addSql('DROP TABLE forum');
    }
}
