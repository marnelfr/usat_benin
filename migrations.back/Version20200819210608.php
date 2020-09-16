<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200819210608 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_file ADD vehicle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_file ADD CONSTRAINT FK_EB3A44C5545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('CREATE INDEX IDX_EB3A44C5545317D1 ON demande_file (vehicle_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_file DROP FOREIGN KEY FK_EB3A44C5545317D1');
        $this->addSql('DROP INDEX IDX_EB3A44C5545317D1 ON demande_file');
        $this->addSql('ALTER TABLE demande_file DROP vehicle_id');
    }
}
