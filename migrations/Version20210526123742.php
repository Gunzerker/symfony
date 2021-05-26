<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210526123742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stock_gym');
        $this->addSql('DROP TABLE stock_produit');
        $this->addSql('ALTER TABLE gym CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE zone zone VARCHAR(255) NOT NULL, CHANGE num num VARCHAR(255) NOT NULL, CHANGE lat lat DOUBLE PRECISION NOT NULL, CHANGE lon lon DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE des des VARCHAR(255) NOT NULL, CHANGE prix prix DOUBLE PRECISION NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE lastmod lastmod VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE stock ADD id_produit_id INT DEFAULT NULL, CHANGE qte id_gym_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660268A9AEE FOREIGN KEY (id_gym_id) REFERENCES gym (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660AABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_4B365660268A9AEE ON stock (id_gym_id)');
        $this->addSql('CREATE INDEX IDX_4B365660AABEFE2C ON stock (id_produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stock_gym (stock_id INT NOT NULL, gym_id INT NOT NULL, INDEX IDX_9496E7BDCD6110 (stock_id), INDEX IDX_9496E7BBD2F03 (gym_id), PRIMARY KEY(stock_id, gym_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE stock_produit (stock_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_3003FC84DCD6110 (stock_id), INDEX IDX_3003FC84F347EFB (produit_id), PRIMARY KEY(stock_id, produit_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE stock_gym ADD CONSTRAINT FK_9496E7BBD2F03 FOREIGN KEY (gym_id) REFERENCES gym (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_gym ADD CONSTRAINT FK_9496E7BDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_produit ADD CONSTRAINT FK_3003FC84DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_produit ADD CONSTRAINT FK_3003FC84F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gym CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE zone zone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE num num VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lat lat DOUBLE PRECISION DEFAULT NULL, CHANGE lon lon DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE produit CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE des des VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prix prix DOUBLE PRECISION DEFAULT NULL, CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastmod lastmod VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660268A9AEE');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660AABEFE2C');
        $this->addSql('DROP INDEX IDX_4B365660268A9AEE ON stock');
        $this->addSql('DROP INDEX IDX_4B365660AABEFE2C ON stock');
        $this->addSql('ALTER TABLE stock ADD qte INT DEFAULT NULL, DROP id_gym_id, DROP id_produit_id');
    }
}
