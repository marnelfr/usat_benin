<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810212946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE importer DROP FOREIGN KEY FK_64E883E8BF396750');
        $this->addSql('ALTER TABLE importer ADD name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD phone VARCHAR(30) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE remover DROP FOREIGN KEY FK_4AB84F2CBF396750');
        $this->addSql('ALTER TABLE remover ADD name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD phone VARCHAR(30) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE importer DROP name, DROP last_name, DROP phone, DROP email, DROP address, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE importer ADD CONSTRAINT FK_64E883E8BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE remover DROP name, DROP last_name, DROP phone, DROP email, DROP address, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE remover ADD CONSTRAINT FK_4AB84F2CBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }
}
