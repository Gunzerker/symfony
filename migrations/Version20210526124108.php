<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210526124108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660268A9AEE');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660AABEFE2C');
        $this->addSql('DROP INDEX IDX_4B365660AABEFE2C ON stock');
        $this->addSql('DROP INDEX IDX_4B365660268A9AEE ON stock');
        $this->addSql('ALTER TABLE stock ADD id_gym_id INT DEFAULT NULL, ADD id_produit_id INT DEFAULT NULL, ADD qte INT NOT NULL, DROP id_gym, DROP id_produit');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660268A9AEE FOREIGN KEY (id_gym_id) REFERENCES gym (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660AABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_4B365660AABEFE2C ON stock (id_produit_id)');
        $this->addSql('CREATE INDEX IDX_4B365660268A9AEE ON stock (id_gym_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660268A9AEE');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660AABEFE2C');
        $this->addSql('DROP INDEX IDX_4B365660268A9AEE ON stock');
        $this->addSql('DROP INDEX IDX_4B365660AABEFE2C ON stock');
        $this->addSql('ALTER TABLE stock ADD id_gym INT DEFAULT NULL, ADD id_produit INT DEFAULT NULL, DROP id_gym_id, DROP id_produit_id, DROP qte');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660268A9AEE FOREIGN KEY (id_gym) REFERENCES gym (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660AABEFE2C FOREIGN KEY (id_produit) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_4B365660268A9AEE ON stock (id_gym)');
        $this->addSql('CREATE INDEX IDX_4B365660AABEFE2C ON stock (id_produit)');
    }
}
