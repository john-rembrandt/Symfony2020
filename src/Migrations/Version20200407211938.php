<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407211938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news DROP FOREIGN KEY news_ibfk_1');
        $this->addSql('ALTER TABLE news ADD news_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950F08ACF73 FOREIGN KEY (news_user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_1DD39950F08ACF73 ON news (news_user_id)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY users_ibfk_1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950F08ACF73');
        $this->addSql('DROP INDEX IDX_1DD39950F08ACF73 ON news');
        $this->addSql('ALTER TABLE news DROP news_user_id');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT news_ibfk_1 FOREIGN KEY (id) REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT users_ibfk_1 FOREIGN KEY (id) REFERENCES news (id) ON UPDATE CASCADE ON DELETE NO ACTION');
    }
}
