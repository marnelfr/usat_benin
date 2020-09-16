<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200830215320 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE removal ADD fleet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE removal ADD CONSTRAINT FK_D4DBB74B4B061DF9 FOREIGN KEY (fleet_id) REFERENCES fleet (id)');
        $this->addSql('CREATE INDEX IDX_D4DBB74B4B061DF9 ON removal (fleet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE removal DROP FOREIGN KEY FK_D4DBB74B4B061DF9');
        $this->addSql('DROP INDEX IDX_D4DBB74B4B061DF9 ON removal');
        $this->addSql('ALTER TABLE removal DROP fleet_id');
    }
}
