<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200809191034 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ship ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vehicle ADD created_at DATETIME NOT NULL, CHANGE put_in_use_at put_in_use_at DATE NOT NULL, CHANGE came_at came_at DATE NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B80E48635C973DF ON vehicle (chassis)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ship DROP slug');
        $this->addSql('DROP INDEX UNIQ_1B80E48635C973DF ON vehicle');
        $this->addSql('ALTER TABLE vehicle DROP created_at, CHANGE put_in_use_at put_in_use_at DATETIME NOT NULL, CHANGE came_at came_at DATETIME NOT NULL');
    }
}
