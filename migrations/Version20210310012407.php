<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310012407 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE logger (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, entity_name VARCHAR(255) NOT NULL, entity_id INT DEFAULT NULL, action VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, ip VARCHAR(15) NOT NULL, made_at DATETIME NOT NULL, INDEX IDX_987E13F3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE logger ADD CONSTRAINT FK_987E13F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE sys_departement');
        $this->addSql('DROP TABLE sys_employe');
        $this->addSql('DROP TABLE sys_users');
        $this->addSql('ALTER TABLE profil CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE removal CHANGE entry_num entry_num VARCHAR(255) NOT NULL');
//        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(180) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sys_departement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(30) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sys_employe (id INT AUTO_INCREMENT NOT NULL, nom_employe VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, prenom_employe VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, id_departement INT NOT NULL, INDEX FK_2AED620D38B217A7 (id_departement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sys_users (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, prenom VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, email VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, password VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('DROP TABLE logger');
        $this->addSql('ALTER TABLE profil CHANGE slug slug VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE removal CHANGE entry_num entry_num VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
