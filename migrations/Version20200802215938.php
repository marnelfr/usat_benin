<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200802215938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(30) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, last_connection DATETIME NOT NULL, compagny VARCHAR(255) DEFAULT NULL, ifu VARCHAR(255) DEFAULT NULL, register_num VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_file (id INT AUTO_INCREMENT NOT NULL, removal_id INT DEFAULT NULL, transfer_id INT DEFAULT NULL, file_id INT NOT NULL, used_for VARCHAR(255) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_EB3A44C5A00B94E6 (removal_id), INDEX IDX_EB3A44C5537048AF (transfer_id), UNIQUE INDEX UNIQ_EB3A44C593CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, client_name VARCHAR(255) NOT NULL, size BIGINT NOT NULL, link VARCHAR(255) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_8C9F3610A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fleet (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, info LONGTEXT DEFAULT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_A05E1E47A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE home_announce (id INT AUTO_INCREMENT NOT NULL, summary LONGTEXT NOT NULL, content LONGTEXT NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE importer (id INT AUTO_INCREMENT NOT NULL, manager_id INT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(30) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, last_connection DATETIME NOT NULL, INDEX IDX_64E883E8783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manager (id INT AUTO_INCREMENT NOT NULL, fleet_id INT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(30) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, last_connection DATETIME NOT NULL, compagny VARCHAR(255) DEFAULT NULL, ifu VARCHAR(255) DEFAULT NULL, register_num VARCHAR(255) DEFAULT NULL, INDEX IDX_FA2425B94B061DF9 (fleet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE processing (id INT AUTO_INCREMENT NOT NULL, transfer_id INT DEFAULT NULL, removal_id INT DEFAULT NULL, user_id INT NOT NULL, verdict TINYINT(1) NOT NULL, reason LONGTEXT NOT NULL, INDEX IDX_886CAB2B537048AF (transfer_id), INDEX IDX_886CAB2BA00B94E6 (removal_id), INDEX IDX_886CAB2BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE removal (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, vehicle_id INT NOT NULL, remover_id INT NOT NULL, pay_bank_id INT NOT NULL, status VARCHAR(30) NOT NULL, bfu_num VARCHAR(255) NOT NULL, entry_num VARCHAR(255) NOT NULL, INDEX IDX_D4DBB74B3414710B (agent_id), UNIQUE INDEX UNIQ_D4DBB74B545317D1 (vehicle_id), INDEX IDX_D4DBB74BE54D128A (remover_id), INDEX IDX_D4DBB74BF7223C8A (pay_bank_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remover (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, cin_id INT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(30) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, last_connection DATETIME NOT NULL, INDEX IDX_4AB84F2C3414710B (agent_id), UNIQUE INDEX UNIQ_4AB84F2CE9795579 (cin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ship (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transfer (id INT AUTO_INCREMENT NOT NULL, manager_id INT NOT NULL, vehicle_id INT NOT NULL, status VARCHAR(30) NOT NULL, deleted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_4034A3C0783E3463 (manager_id), UNIQUE INDEX UNIQ_4034A3C0545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profil_id INT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(30) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, last_connection DATETIME NOT NULL, INDEX IDX_8D93D649275ED078 (profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, ship_id INT NOT NULL, importer_id INT NOT NULL, chassis VARCHAR(255) NOT NULL, put_in_use_at DATETIME NOT NULL, came_at DATETIME NOT NULL, consignee VARCHAR(255) NOT NULL, INDEX IDX_1B80E48644F5D008 (brand_id), INDEX IDX_1B80E486C256317D (ship_id), INDEX IDX_1B80E4867FCFE58E (importer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_file ADD CONSTRAINT FK_EB3A44C5A00B94E6 FOREIGN KEY (removal_id) REFERENCES removal (id)');
        $this->addSql('ALTER TABLE demande_file ADD CONSTRAINT FK_EB3A44C5537048AF FOREIGN KEY (transfer_id) REFERENCES transfer (id)');
        $this->addSql('ALTER TABLE demande_file ADD CONSTRAINT FK_EB3A44C593CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fleet ADD CONSTRAINT FK_A05E1E47A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE importer ADD CONSTRAINT FK_64E883E8783E3463 FOREIGN KEY (manager_id) REFERENCES manager (id)');
        $this->addSql('ALTER TABLE manager ADD CONSTRAINT FK_FA2425B94B061DF9 FOREIGN KEY (fleet_id) REFERENCES fleet (id)');
        $this->addSql('ALTER TABLE processing ADD CONSTRAINT FK_886CAB2B537048AF FOREIGN KEY (transfer_id) REFERENCES transfer (id)');
        $this->addSql('ALTER TABLE processing ADD CONSTRAINT FK_886CAB2BA00B94E6 FOREIGN KEY (removal_id) REFERENCES removal (id)');
        $this->addSql('ALTER TABLE processing ADD CONSTRAINT FK_886CAB2BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE removal ADD CONSTRAINT FK_D4DBB74B3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE removal ADD CONSTRAINT FK_D4DBB74B545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE removal ADD CONSTRAINT FK_D4DBB74BE54D128A FOREIGN KEY (remover_id) REFERENCES remover (id)');
        $this->addSql('ALTER TABLE removal ADD CONSTRAINT FK_D4DBB74BF7223C8A FOREIGN KEY (pay_bank_id) REFERENCES bank (id)');
        $this->addSql('ALTER TABLE remover ADD CONSTRAINT FK_4AB84F2C3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE remover ADD CONSTRAINT FK_4AB84F2CE9795579 FOREIGN KEY (cin_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE transfer ADD CONSTRAINT FK_4034A3C0783E3463 FOREIGN KEY (manager_id) REFERENCES manager (id)');
        $this->addSql('ALTER TABLE transfer ADD CONSTRAINT FK_4034A3C0545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48644F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486C256317D FOREIGN KEY (ship_id) REFERENCES ship (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4867FCFE58E FOREIGN KEY (importer_id) REFERENCES importer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE removal DROP FOREIGN KEY FK_D4DBB74B3414710B');
        $this->addSql('ALTER TABLE remover DROP FOREIGN KEY FK_4AB84F2C3414710B');
        $this->addSql('ALTER TABLE removal DROP FOREIGN KEY FK_D4DBB74BF7223C8A');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48644F5D008');
        $this->addSql('ALTER TABLE demande_file DROP FOREIGN KEY FK_EB3A44C593CB796C');
        $this->addSql('ALTER TABLE remover DROP FOREIGN KEY FK_4AB84F2CE9795579');
        $this->addSql('ALTER TABLE manager DROP FOREIGN KEY FK_FA2425B94B061DF9');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4867FCFE58E');
        $this->addSql('ALTER TABLE importer DROP FOREIGN KEY FK_64E883E8783E3463');
        $this->addSql('ALTER TABLE transfer DROP FOREIGN KEY FK_4034A3C0783E3463');
        $this->addSql('ALTER TABLE demande_file DROP FOREIGN KEY FK_EB3A44C5A00B94E6');
        $this->addSql('ALTER TABLE processing DROP FOREIGN KEY FK_886CAB2BA00B94E6');
        $this->addSql('ALTER TABLE removal DROP FOREIGN KEY FK_D4DBB74BE54D128A');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486C256317D');
        $this->addSql('ALTER TABLE demande_file DROP FOREIGN KEY FK_EB3A44C5537048AF');
        $this->addSql('ALTER TABLE processing DROP FOREIGN KEY FK_886CAB2B537048AF');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610A76ED395');
        $this->addSql('ALTER TABLE fleet DROP FOREIGN KEY FK_A05E1E47A76ED395');
        $this->addSql('ALTER TABLE processing DROP FOREIGN KEY FK_886CAB2BA76ED395');
        $this->addSql('ALTER TABLE removal DROP FOREIGN KEY FK_D4DBB74B545317D1');
        $this->addSql('ALTER TABLE transfer DROP FOREIGN KEY FK_4034A3C0545317D1');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE bank');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE demande_file');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE fleet');
        $this->addSql('DROP TABLE home_announce');
        $this->addSql('DROP TABLE importer');
        $this->addSql('DROP TABLE manager');
        $this->addSql('DROP TABLE processing');
        $this->addSql('DROP TABLE removal');
        $this->addSql('DROP TABLE remover');
        $this->addSql('DROP TABLE ship');
        $this->addSql('DROP TABLE transfer');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vehicle');
    }
}
