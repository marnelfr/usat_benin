<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818223353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle ADD remover_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486E54D128A FOREIGN KEY (remover_id) REFERENCES remover (id)');
        $this->addSql('CREATE INDEX IDX_1B80E486E54D128A ON vehicle (remover_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486E54D128A');
        $this->addSql('DROP INDEX IDX_1B80E486E54D128A ON vehicle');
        $this->addSql('ALTER TABLE vehicle DROP remover_id');
    }
}
