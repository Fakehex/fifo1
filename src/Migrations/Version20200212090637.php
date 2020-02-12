<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212090637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE inscrit (id INT AUTO_INCREMENT NOT NULL, maison_id INT DEFAULT NULL, evenement_id INT NOT NULL, leader_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_927FA3659D67D8AF (maison_id), INDEX IDX_927FA365FD02F13 (evenement_id), INDEX IDX_927FA365A76ED395 (user_id), INDEX IDX_927FA36573154ED4 (leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, bracket_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, texte LONGTEXT NOT NULL, date DATETIME DEFAULT NULL, published_at DATETIME NOT NULL, nb_inscrits INT NOT NULL, is_tournoi TINYINT(1) NOT NULL, salle VARCHAR(255) NOT NULL, inscription_ouverte TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_B26681E6E8D78 (bracket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE duel (id INT AUTO_INCREMENT NOT NULL, inscrit_id INT DEFAULT NULL, bracket_id INT DEFAULT NULL, bracket_double_id INT DEFAULT NULL, score_inscrit1 INT DEFAULT NULL, score_inscrit2 INT DEFAULT NULL, tour INT NOT NULL, INDEX IDX_9BB4A7626DCD4FEE (inscrit_id), INDEX IDX_9BB4A7626E8D78 (bracket_id), INDEX IDX_9BB4A76258B4A49B (bracket_double_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, topic_id INT NOT NULL, text LONGTEXT NOT NULL, published_at DATETIME NOT NULL, INDEX IDX_67F068BCA76ED395 (user_id), INDEX IDX_67F068BC1F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bracket (id INT AUTO_INCREMENT NOT NULL, tour_actuel INT NOT NULL, type VARCHAR(255) NOT NULL, tour_perdant INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, texte LONGTEXT NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_140AB620989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_matiere (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_CF97F9E8989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maison (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, points INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE correction (id INT AUTO_INCREMENT NOT NULL, archive_id INT NOT NULL, user_id INT NOT NULL, correction VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, date DATE NOT NULL, pocebleu INT NOT NULL, INDEX IDX_A29DA1B82956195F (archive_id), INDEX IDX_A29DA1B8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE archives (id INT AUTO_INCREMENT NOT NULL, matiere_id INT DEFAULT NULL, sujet VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, seconde_session TINYINT(1) DEFAULT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_E262EC39989D9B62 (slug), INDEX IDX_E262EC39F46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_forum (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_7053531D989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, categorie_forum_id INT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, slug VARCHAR(128) NOT NULL, date DATETIME NOT NULL, nb_commentaires INT NOT NULL, UNIQUE INDEX UNIQ_9D40DE1B989D9B62 (slug), INDEX IDX_9D40DE1B114BFBBA (categorie_forum_id), INDEX IDX_9D40DE1BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_9014574A989D9B62 (slug), INDEX IDX_9014574ABCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscrit ADD CONSTRAINT FK_927FA3659D67D8AF FOREIGN KEY (maison_id) REFERENCES maison (id)');
        $this->addSql('ALTER TABLE inscrit ADD CONSTRAINT FK_927FA365FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE inscrit ADD CONSTRAINT FK_927FA36573154ED4 FOREIGN KEY (leader_id) REFERENCES inscrit (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E6E8D78 FOREIGN KEY (bracket_id) REFERENCES bracket (id)');
        $this->addSql('ALTER TABLE duel ADD CONSTRAINT FK_9BB4A7626DCD4FEE FOREIGN KEY (inscrit_id) REFERENCES inscrit (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE duel ADD CONSTRAINT FK_9BB4A7626E8D78 FOREIGN KEY (bracket_id) REFERENCES bracket (id)');
        $this->addSql('ALTER TABLE duel ADD CONSTRAINT FK_9BB4A76258B4A49B FOREIGN KEY (bracket_double_id) REFERENCES bracket (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE correction ADD CONSTRAINT FK_A29DA1B82956195F FOREIGN KEY (archive_id) REFERENCES archives (id)');
        $this->addSql('ALTER TABLE correction ADD CONSTRAINT FK_A29DA1B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE archives ADD CONSTRAINT FK_E262EC39F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B114BFBBA FOREIGN KEY (categorie_forum_id) REFERENCES categorie_forum (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574ABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_matiere (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inscrit DROP FOREIGN KEY FK_927FA36573154ED4');
        $this->addSql('ALTER TABLE duel DROP FOREIGN KEY FK_9BB4A7626DCD4FEE');
        $this->addSql('ALTER TABLE inscrit DROP FOREIGN KEY FK_927FA365FD02F13');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E6E8D78');
        $this->addSql('ALTER TABLE duel DROP FOREIGN KEY FK_9BB4A7626E8D78');
        $this->addSql('ALTER TABLE duel DROP FOREIGN KEY FK_9BB4A76258B4A49B');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574ABCF5E72D');
        $this->addSql('ALTER TABLE inscrit DROP FOREIGN KEY FK_927FA3659D67D8AF');
        $this->addSql('ALTER TABLE correction DROP FOREIGN KEY FK_A29DA1B82956195F');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE correction DROP FOREIGN KEY FK_A29DA1B8A76ED395');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BA76ED395');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B114BFBBA');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC1F55203D');
        $this->addSql('ALTER TABLE archives DROP FOREIGN KEY FK_E262EC39F46CD258');
        $this->addSql('DROP TABLE inscrit');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE duel');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE bracket');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE categorie_matiere');
        $this->addSql('DROP TABLE maison');
        $this->addSql('DROP TABLE correction');
        $this->addSql('DROP TABLE archives');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE categorie_forum');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE matiere');
    }
}
