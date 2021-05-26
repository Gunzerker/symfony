<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210526122509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gym (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, zone VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, num VARCHAR(255) DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, lon DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, des VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, lastmod VARCHAR(255) DEFAULT NULL, modby INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, qte INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_gym (stock_id INT NOT NULL, gym_id INT NOT NULL, INDEX IDX_9496E7BDCD6110 (stock_id), INDEX IDX_9496E7BBD2F03 (gym_id), PRIMARY KEY(stock_id, gym_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_produit (stock_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_3003FC84DCD6110 (stock_id), INDEX IDX_3003FC84F347EFB (produit_id), PRIMARY KEY(stock_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stock_gym ADD CONSTRAINT FK_9496E7BDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_gym ADD CONSTRAINT FK_9496E7BBD2F03 FOREIGN KEY (gym_id) REFERENCES gym (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_produit ADD CONSTRAINT FK_3003FC84DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_produit ADD CONSTRAINT FK_3003FC84F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock_gym DROP FOREIGN KEY FK_9496E7BBD2F03');
        $this->addSql('ALTER TABLE stock_produit DROP FOREIGN KEY FK_3003FC84F347EFB');
        $this->addSql('ALTER TABLE stock_gym DROP FOREIGN KEY FK_9496E7BDCD6110');
        $this->addSql('ALTER TABLE stock_produit DROP FOREIGN KEY FK_3003FC84DCD6110');
        $this->addSql('DROP TABLE gym');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE stock_gym');
        $this->addSql('DROP TABLE stock_produit');
    }
}
