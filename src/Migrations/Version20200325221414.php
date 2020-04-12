<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200325221414 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token VARCHAR(255) NOT NULL, created DATETIME NOT NULL, expires DATETIME NOT NULL, INDEX IDX_D044D5D4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ban CHANGE author_id author_id INT DEFAULT NULL, CHANGE notes notes VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE permission_id permission_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE forum CHANGE min_role_id min_role_id INT DEFAULT NULL, CHANGE subforum_id subforum_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE permission CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reply CHANGE author_id author_id INT DEFAULT NULL, CHANGE updated updated DATETIME DEFAULT NULL, CHANGE deleted deleted DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE thread CHANGE updated updated DATETIME DEFAULT NULL, CHANGE deleted deleted DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE updated updated DATETIME DEFAULT NULL, CHANGE dob dob DATE DEFAULT NULL, CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL, CHANGE last_ip_address last_ip_address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_role CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE warning CHANGE author_id author_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE session');
        $this->addSql('ALTER TABLE ban CHANGE author_id author_id INT DEFAULT NULL, CHANGE notes notes VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE category CHANGE permission_id permission_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE forum CHANGE min_role_id min_role_id INT DEFAULT NULL, CHANGE subforum_id subforum_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE permission CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reply CHANGE author_id author_id INT DEFAULT NULL, CHANGE updated updated DATETIME DEFAULT \'NULL\', CHANGE deleted deleted DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE thread CHANGE updated updated DATETIME DEFAULT \'NULL\', CHANGE deleted deleted DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE updated updated DATETIME DEFAULT \'NULL\', CHANGE dob dob DATE DEFAULT \'NULL\', CHANGE gender gender VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE location location VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE last_ip_address last_ip_address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user_role CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE warning CHANGE author_id author_id INT DEFAULT NULL');
    }
}
