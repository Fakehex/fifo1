<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190425085531 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscrit ADD evenement_id INT NOT NULL, CHANGE maison_id maison_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE equipe_id equipe_id INT DEFAULT NULL, CHANGE leader_id leader_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscrit ADD CONSTRAINT FK_927FA365FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_927FA365FD02F13 ON inscrit (evenement_id)');
        $this->addSql('ALTER TABLE evenement CHANGE date date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE maison CHANGE points points INT DEFAULT NULL');
        $this->addSql('ALTER TABLE archives CHANGE matiere_id matiere_id INT DEFAULT NULL, CHANGE date date DATE DEFAULT NULL, CHANGE seconde_session seconde_session TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere CHANGE categorie_id categorie_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE archives CHANGE matiere_id matiere_id INT DEFAULT NULL, CHANGE date date DATE DEFAULT \'NULL\', CHANGE seconde_session seconde_session TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE evenement CHANGE date date DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE inscrit DROP FOREIGN KEY FK_927FA365FD02F13');
        $this->addSql('DROP INDEX IDX_927FA365FD02F13 ON inscrit');
        $this->addSql('ALTER TABLE inscrit DROP evenement_id, CHANGE maison_id maison_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE equipe_id equipe_id INT DEFAULT NULL, CHANGE leader_id leader_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE maison CHANGE points points INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere CHANGE categorie_id categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE reset_token reset_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
