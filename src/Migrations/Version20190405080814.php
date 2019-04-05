<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190405080814 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE archives ADD matiere_id INT DEFAULT NULL, CHANGE date date DATE DEFAULT NULL, CHANGE seconde_session seconde_session TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE archives ADD CONSTRAINT FK_E262EC39F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('CREATE INDEX IDX_E262EC39F46CD258 ON archives (matiere_id)');
        $this->addSql('ALTER TABLE matiere CHANGE categorie_id categorie_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE archives DROP FOREIGN KEY FK_E262EC39F46CD258');
        $this->addSql('DROP INDEX IDX_E262EC39F46CD258 ON archives');
        $this->addSql('ALTER TABLE archives DROP matiere_id, CHANGE date date DATE DEFAULT \'NULL\', CHANGE seconde_session seconde_session TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE matiere CHANGE categorie_id categorie_id INT DEFAULT NULL');
    }
}
