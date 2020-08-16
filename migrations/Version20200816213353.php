<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200816213353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remover DROP FOREIGN KEY FK_4AB84F2CE9795579');
        $this->addSql('DROP INDEX UNIQ_4AB84F2CE9795579 ON remover');
        $this->addSql('ALTER TABLE remover ADD cin_file_name VARCHAR(255) NOT NULL, DROP cin_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remover ADD cin_id INT NOT NULL, DROP cin_file_name');
        $this->addSql('ALTER TABLE remover ADD CONSTRAINT FK_4AB84F2CE9795579 FOREIGN KEY (cin_id) REFERENCES file (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4AB84F2CE9795579 ON remover (cin_id)');
    }
}
