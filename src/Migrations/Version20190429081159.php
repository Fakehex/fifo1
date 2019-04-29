<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190429081159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, inscrit1_id INT DEFAULT NULL, inscrit2_id INT DEFAULT NULL, score_equipe1 INT NOT NULL, score_equipe2 INT NOT NULL, tour INT NOT NULL, INDEX IDX_7A5BC50591B32FA3 (inscrit1_id), INDEX IDX_7A5BC5058306804D (inscrit2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC50591B32FA3 FOREIGN KEY (inscrit1_id) REFERENCES inscrit (id)');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC5058306804D FOREIGN KEY (inscrit2_id) REFERENCES inscrit (id)');
        $this->addSql('ALTER TABLE archives CHANGE matiere_id matiere_id INT DEFAULT NULL, CHANGE date date DATE DEFAULT NULL, CHANGE seconde_session seconde_session TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE inscrit CHANGE maison_id maison_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE equipe_id equipe_id INT DEFAULT NULL, CHANGE leader_id leader_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement DROP nb_inscrits, CHANGE date date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE maison CHANGE points points INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere CHANGE categorie_id categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE statut statut VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `match`');
        $this->addSql('ALTER TABLE archives CHANGE matiere_id matiere_id INT DEFAULT NULL, CHANGE date date DATE DEFAULT \'NULL\', CHANGE seconde_session seconde_session TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE evenement ADD nb_inscrits INT NOT NULL, CHANGE date date DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE inscrit CHANGE maison_id maison_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE equipe_id equipe_id INT DEFAULT NULL, CHANGE leader_id leader_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE maison CHANGE points points INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere CHANGE categorie_id categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE reset_token reset_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE prenom prenom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE nom nom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE statut statut VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
