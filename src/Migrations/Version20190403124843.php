<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190403124843 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE archives (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, seconde_session TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_matiere (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE correction (id INT AUTO_INCREMENT NOT NULL, archive_id INT NOT NULL, correction VARCHAR(255) NOT NULL, date DATE NOT NULL, pocebleu INT NOT NULL, INDEX IDX_A29DA1B82956195F (archive_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_9014574ABCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE correction ADD CONSTRAINT FK_A29DA1B82956195F FOREIGN KEY (archive_id) REFERENCES archives (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574ABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_matiere (id)');
        $this->addSql('DROP INDEX UNIQ_8D93D64986CC499D ON user');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(180) NOT NULL, DROP pseudo, CHANGE email email VARCHAR(100) NOT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE correction DROP FOREIGN KEY FK_A29DA1B82956195F');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574ABCF5E72D');
        $this->addSql('DROP TABLE archives');
        $this->addSql('DROP TABLE categorie_matiere');
        $this->addSql('DROP TABLE correction');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user ADD pseudo VARCHAR(12) NOT NULL COLLATE utf8mb4_unicode_ci, DROP username, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE email email VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64986CC499D ON user (pseudo)');
    }
}
