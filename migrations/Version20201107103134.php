<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107103134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discount ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE discount ADD CONSTRAINT FK_E1E0B40EC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E1E0B40EC54C8C93 ON discount (type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discount DROP FOREIGN KEY FK_E1E0B40EC54C8C93');
        $this->addSql('DROP INDEX UNIQ_E1E0B40EC54C8C93 ON discount');
        $this->addSql('ALTER TABLE discount DROP type_id');
    }
}
