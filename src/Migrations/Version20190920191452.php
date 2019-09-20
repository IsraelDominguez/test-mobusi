<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920191452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE component (id INT AUTO_INCREMENT NOT NULL, ad_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, pos_x DOUBLE PRECISION NOT NULL, pos_y DOUBLE PRECISION NOT NULL, pos_z DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, width DOUBLE PRECISION NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_49FEA1574F34D596 (ad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE text (id INT NOT NULL, text VARCHAR(140) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ad (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT NOT NULL, path VARCHAR(500) NOT NULL, mime_type VARCHAR(30) NOT NULL, size DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT NOT NULL, path VARCHAR(500) NOT NULL, mime_type VARCHAR(30) NOT NULL, size DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE component ADD CONSTRAINT FK_49FEA1574F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id)');
        $this->addSql('ALTER TABLE text ADD CONSTRAINT FK_3B8BA7C7BF396750 FOREIGN KEY (id) REFERENCES component (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CBF396750 FOREIGN KEY (id) REFERENCES component (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBF396750 FOREIGN KEY (id) REFERENCES component (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE text DROP FOREIGN KEY FK_3B8BA7C7BF396750');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CBF396750');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBF396750');
        $this->addSql('ALTER TABLE component DROP FOREIGN KEY FK_49FEA1574F34D596');
        $this->addSql('DROP TABLE component');
        $this->addSql('DROP TABLE text');
        $this->addSql('DROP TABLE ad');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE image');
    }
}
