<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190424143609 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE inscrit (id INT AUTO_INCREMENT NOT NULL, maison_id INT DEFAULT NULL, user_id INT DEFAULT NULL, equipe_id INT DEFAULT NULL, leader_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_927FA3659D67D8AF (maison_id), INDEX IDX_927FA365A76ED395 (user_id), INDEX IDX_927FA3656D861B89 (equipe_id), INDEX IDX_927FA36573154ED4 (leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maison (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, points INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscrit ADD CONSTRAINT FK_927FA3659D67D8AF FOREIGN KEY (maison_id) REFERENCES maison (id)');
        $this->addSql('ALTER TABLE inscrit ADD CONSTRAINT FK_927FA365A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscrit ADD CONSTRAINT FK_927FA3656D861B89 FOREIGN KEY (equipe_id) REFERENCES inscrit (id)');
        $this->addSql('ALTER TABLE inscrit ADD CONSTRAINT FK_927FA36573154ED4 FOREIGN KEY (leader_id) REFERENCES inscrit (id)');
        $this->addSql('DROP TABLE evenement_user');
        $this->addSql('DROP INDEX UNIQ_B26681E989D9B62 ON evenement');
        $this->addSql('ALTER TABLE evenement ADD date DATETIME DEFAULT NULL, ADD published_at DATETIME NOT NULL, DROP slug');
        $this->addSql('ALTER TABLE archives CHANGE matiere_id matiere_id INT DEFAULT NULL, CHANGE date date DATE DEFAULT NULL, CHANGE seconde_session seconde_session TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP prenom, DROP nom, DROP statut, CHANGE roles roles JSON NOT NULL, CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere CHANGE categorie_id categorie_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscrit DROP FOREIGN KEY FK_927FA3656D861B89');
        $this->addSql('ALTER TABLE inscrit DROP FOREIGN KEY FK_927FA36573154ED4');
        $this->addSql('ALTER TABLE inscrit DROP FOREIGN KEY FK_927FA3659D67D8AF');
        $this->addSql('CREATE TABLE evenement_user (evenement_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_2EC0B3C4A76ED395 (user_id), INDEX IDX_2EC0B3C4FD02F13 (evenement_id), PRIMARY KEY(evenement_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evenement_user ADD CONSTRAINT FK_2EC0B3C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_user ADD CONSTRAINT FK_2EC0B3C4FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE inscrit');
        $this->addSql('DROP TABLE maison');
        $this->addSql('ALTER TABLE archives CHANGE matiere_id matiere_id INT DEFAULT NULL, CHANGE date date DATE DEFAULT \'NULL\', CHANGE seconde_session seconde_session TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE evenement ADD slug VARCHAR(128) NOT NULL COLLATE utf8mb4_unicode_ci, DROP date, DROP published_at');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B26681E989D9B62 ON evenement (slug)');
        $this->addSql('ALTER TABLE matiere CHANGE categorie_id categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD prenom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, ADD nom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, ADD statut VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE reset_token reset_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
