<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180409141518 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('INSERT INTO role(label) VALUE("ROLE_ACTIVE")');
        // this up() migration is auto-generated, please modify it to your needs
    }

    public function down(Schema $schema)
    {
        $this->addSql('DELETE FROM role WHERE label = "ROLE_ACTIVE"');
        // this down() migration is auto-generated, please modify it to your needs
    }
}
