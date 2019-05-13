<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190510100635 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE duel ADD inscrit1_id INT DEFAULT NULL, ADD inscrit2_id INT DEFAULT NULL, DROP inscrit1, DROP inscrit2, CHANGE bracket_id bracket_id INT DEFAULT NULL, CHANGE bracket_double_id bracket_double_id INT DEFAULT NULL, CHANGE score_inscrit1 score_inscrit1 INT DEFAULT NULL, CHANGE score_inscrit2 score_inscrit2 INT DEFAULT NULL');
        $this->addSql('ALTER TABLE duel ADD CONSTRAINT FK_9BB4A76291B32FA3 FOREIGN KEY (inscrit1_id) REFERENCES inscrit (id)');
        $this->addSql('ALTER TABLE duel ADD CONSTRAINT FK_9BB4A7628306804D FOREIGN KEY (inscrit2_id) REFERENCES inscrit (id)');
        $this->addSql('CREATE INDEX IDX_9BB4A76291B32FA3 ON duel (inscrit1_id)');
        $this->addSql('CREATE INDEX IDX_9BB4A7628306804D ON duel (inscrit2_id)');
        $this->addSql('ALTER TABLE bracket CHANGE tour_perdant tour_perdant INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscrit CHANGE maison_id maison_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE equipe_id equipe_id INT DEFAULT NULL, CHANGE leader_id leader_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement CHANGE bracket_id bracket_id INT DEFAULT NULL, CHANGE date date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE maison CHANGE points points INT DEFAULT NULL');
        $this->addSql('ALTER TABLE archives CHANGE matiere_id matiere_id INT DEFAULT NULL, CHANGE date date DATE DEFAULT NULL, CHANGE seconde_session seconde_session TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE statut statut VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere CHANGE categorie_id categorie_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE archives CHANGE matiere_id matiere_id INT DEFAULT NULL, CHANGE date date DATE DEFAULT \'NULL\', CHANGE seconde_session seconde_session TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE bracket CHANGE tour_perdant tour_perdant INT DEFAULT NULL');
        $this->addSql('ALTER TABLE duel DROP FOREIGN KEY FK_9BB4A76291B32FA3');
        $this->addSql('ALTER TABLE duel DROP FOREIGN KEY FK_9BB4A7628306804D');
        $this->addSql('DROP INDEX IDX_9BB4A76291B32FA3 ON duel');
        $this->addSql('DROP INDEX IDX_9BB4A7628306804D ON duel');
        $this->addSql('ALTER TABLE duel ADD inscrit1 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, ADD inscrit2 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, DROP inscrit1_id, DROP inscrit2_id, CHANGE bracket_id bracket_id INT DEFAULT NULL, CHANGE bracket_double_id bracket_double_id INT DEFAULT NULL, CHANGE score_inscrit1 score_inscrit1 INT DEFAULT NULL, CHANGE score_inscrit2 score_inscrit2 INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement CHANGE bracket_id bracket_id INT DEFAULT NULL, CHANGE date date DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE inscrit CHANGE maison_id maison_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE equipe_id equipe_id INT DEFAULT NULL, CHANGE leader_id leader_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE maison CHANGE points points INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere CHANGE categorie_id categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE reset_token reset_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE prenom prenom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE nom nom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE statut statut VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
