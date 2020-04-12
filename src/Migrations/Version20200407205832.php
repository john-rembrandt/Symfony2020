<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407205832 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE news ADD news_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950F08ACF73 FOREIGN KEY (news_user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_1DD39950F08ACF73 ON news (news_user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950F08ACF73');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP INDEX IDX_1DD39950F08ACF73 ON news');
        $this->addSql('ALTER TABLE news DROP news_user_id');
    }
}
