<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818213140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE importer DROP FOREIGN KEY FK_64E883E8783E3463');
        $this->addSql('DROP INDEX IDX_64E883E8783E3463 ON importer');
        $this->addSql('ALTER TABLE importer DROP manager_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE importer ADD manager_id INT NOT NULL');
        $this->addSql('ALTER TABLE importer ADD CONSTRAINT FK_64E883E8783E3463 FOREIGN KEY (manager_id) REFERENCES manager (id)');
        $this->addSql('CREATE INDEX IDX_64E883E8783E3463 ON importer (manager_id)');
    }
}
