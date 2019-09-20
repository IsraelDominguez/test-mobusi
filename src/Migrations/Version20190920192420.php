<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920192420 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE publisher (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE advertiser (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ad ADD advertiser_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED58BA2FCBC2 FOREIGN KEY (advertiser_id) REFERENCES advertiser (id)');
        $this->addSql('CREATE INDEX IDX_77E0ED58BA2FCBC2 ON ad (advertiser_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ad DROP FOREIGN KEY FK_77E0ED58BA2FCBC2');
        $this->addSql('DROP TABLE publisher');
        $this->addSql('DROP TABLE advertiser');
        $this->addSql('DROP INDEX IDX_77E0ED58BA2FCBC2 ON ad');
        $this->addSql('ALTER TABLE ad DROP advertiser_id');
    }
}
