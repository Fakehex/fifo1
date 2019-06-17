<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190617124954 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscrit DROP FOREIGN KEY FK_927FA3656D861B89');
        $this->addSql('ALTER TABLE inscrit DROP FOREIGN KEY FK_927FA365A76ED395');
        $this->addSql('DROP INDEX IDX_927FA3656D861B89 ON inscrit');
        $this->addSql('ALTER TABLE inscrit DROP equipe_id, CHANGE maison_id maison_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE leader_id leader_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bracket CHANGE tour_perdant tour_perdant INT DEFAULT NULL');
        $this->addSql('ALTER TABLE duel CHANGE bracket_id bracket_id INT DEFAULT NULL, CHANGE bracket_double_id bracket_double_id INT DEFAULT NULL, CHANGE inscrit1_id inscrit1_id INT DEFAULT NULL, CHANGE inscrit2_id inscrit2_id INT DEFAULT NULL, CHANGE score_inscrit1 score_inscrit1 INT DEFAULT NULL, CHANGE score_inscrit2 score_inscrit2 INT DEFAULT NULL');
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
        $this->addSql('ALTER TABLE duel CHANGE inscrit1_id inscrit1_id INT DEFAULT NULL, CHANGE inscrit2_id inscrit2_id INT DEFAULT NULL, CHANGE bracket_id bracket_id INT DEFAULT NULL, CHANGE bracket_double_id bracket_double_id INT DEFAULT NULL, CHANGE score_inscrit1 score_inscrit1 INT DEFAULT NULL, CHANGE score_inscrit2 score_inscrit2 INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement CHANGE bracket_id bracket_id INT DEFAULT NULL, CHANGE date date DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE inscrit ADD equipe_id INT DEFAULT NULL, CHANGE maison_id maison_id INT DEFAULT NULL, CHANGE leader_id leader_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscrit ADD CONSTRAINT FK_927FA3656D861B89 FOREIGN KEY (equipe_id) REFERENCES inscrit (id)');
        $this->addSql('ALTER TABLE inscrit ADD CONSTRAINT FK_927FA365A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_927FA3656D861B89 ON inscrit (equipe_id)');
        $this->addSql('ALTER TABLE maison CHANGE points points INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere CHANGE categorie_id categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE reset_token reset_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE prenom prenom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE nom nom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE statut statut VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
