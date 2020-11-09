<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201105204025 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discount DROP FOREIGN KEY FK_E1E0B40E765B68E');
        $this->addSql('ALTER TABLE discount DROP FOREIGN KEY FK_E1E0B40E9716C195');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD14959723');
        $this->addSql('DROP TABLE product_type');
        $this->addSql('DROP INDEX IDX_E1E0B40E765B68E ON discount');
        $this->addSql('DROP INDEX IDX_E1E0B40E9716C195 ON discount');
        $this->addSql('ALTER TABLE discount DROP discount_percent_id, DROP type_discount_id');
        $this->addSql('DROP INDEX IDX_D34A04AD14959723 ON product');
        $this->addSql('ALTER TABLE product DROP product_type_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE discount ADD discount_percent_id INT DEFAULT NULL, ADD type_discount_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE discount ADD CONSTRAINT FK_E1E0B40E765B68E FOREIGN KEY (type_discount_id) REFERENCES product_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE discount ADD CONSTRAINT FK_E1E0B40E9716C195 FOREIGN KEY (discount_percent_id) REFERENCES product_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E1E0B40E765B68E ON discount (type_discount_id)');
        $this->addSql('CREATE INDEX IDX_E1E0B40E9716C195 ON discount (discount_percent_id)');
        $this->addSql('ALTER TABLE product ADD product_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD14959723 FOREIGN KEY (product_type_id) REFERENCES product_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D34A04AD14959723 ON product (product_type_id)');
    }
}
