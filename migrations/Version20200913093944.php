<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200913093944 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inform (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_CBF7144EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inform ADD CONSTRAINT FK_CBF7144EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande_file ADD inform_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_file ADD CONSTRAINT FK_EB3A44C51132D5DB FOREIGN KEY (inform_id) REFERENCES inform (id)');
        $this->addSql('CREATE INDEX IDX_EB3A44C51132D5DB ON demande_file (inform_id)');
        $this->addSql('ALTER TABLE profil CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE removal CHANGE entry_num entry_num VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(180) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_file DROP FOREIGN KEY FK_EB3A44C51132D5DB');
        $this->addSql('DROP TABLE inform');
        $this->addSql('DROP INDEX IDX_EB3A44C51132D5DB ON demande_file');
        $this->addSql('ALTER TABLE demande_file DROP inform_id');
        $this->addSql('ALTER TABLE profil CHANGE slug slug VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE removal CHANGE entry_num entry_num VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
