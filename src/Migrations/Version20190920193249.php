<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920193249 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE publisher_ad (publisher_id INT NOT NULL, ad_id INT NOT NULL, INDEX IDX_8811E5C640C86FCE (publisher_id), INDEX IDX_8811E5C64F34D596 (ad_id), PRIMARY KEY(publisher_id, ad_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE publisher_ad ADD CONSTRAINT FK_8811E5C640C86FCE FOREIGN KEY (publisher_id) REFERENCES publisher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publisher_ad ADD CONSTRAINT FK_8811E5C64F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE publisher_ad');
    }
}
