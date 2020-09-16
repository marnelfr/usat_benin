<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200829010908 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_file ADD remover_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_file ADD CONSTRAINT FK_EB3A44C5E54D128A FOREIGN KEY (remover_id) REFERENCES remover (id)');
        $this->addSql('CREATE INDEX IDX_EB3A44C5E54D128A ON demande_file (remover_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_file DROP FOREIGN KEY FK_EB3A44C5E54D128A');
        $this->addSql('DROP INDEX IDX_EB3A44C5E54D128A ON demande_file');
        $this->addSql('ALTER TABLE demande_file DROP remover_id');
    }
}
