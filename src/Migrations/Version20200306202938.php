<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200306202938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, permission_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_64C19C1FED90CCA (permission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, primary_role_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, INDEX IDX_8D93D6491D9A6698 (primary_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role_permission (user_role_id INT NOT NULL, permission_id INT NOT NULL, INDEX IDX_7DA194098E0E3CA6 (user_role_id), INDEX IDX_7DA19409FED90CCA (permission_id), PRIMARY KEY(user_role_id, permission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role_user (user_role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_33CC29398E0E3CA6 (user_role_id), INDEX IDX_33CC2939A76ED395 (user_id), PRIMARY KEY(user_role_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491D9A6698 FOREIGN KEY (primary_role_id) REFERENCES user_role (id)');
        $this->addSql('ALTER TABLE user_role_permission ADD CONSTRAINT FK_7DA194098E0E3CA6 FOREIGN KEY (user_role_id) REFERENCES user_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role_permission ADD CONSTRAINT FK_7DA19409FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role_user ADD CONSTRAINT FK_33CC29398E0E3CA6 FOREIGN KEY (user_role_id) REFERENCES user_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role_user ADD CONSTRAINT FK_33CC2939A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_role_user DROP FOREIGN KEY FK_33CC2939A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491D9A6698');
        $this->addSql('ALTER TABLE user_role_permission DROP FOREIGN KEY FK_7DA194098E0E3CA6');
        $this->addSql('ALTER TABLE user_role_user DROP FOREIGN KEY FK_33CC29398E0E3CA6');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1FED90CCA');
        $this->addSql('ALTER TABLE user_role_permission DROP FOREIGN KEY FK_7DA19409FED90CCA');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE user_role_permission');
        $this->addSql('DROP TABLE user_role_user');
        $this->addSql('DROP TABLE permission');
    }
}
