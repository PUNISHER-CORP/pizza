<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200520185051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE u_user ADD street VARCHAR(255) DEFAULT NULL, ADD house VARCHAR(255) DEFAULT NULL, ADD flat VARCHAR(255) DEFAULT NULL, ADD floor VARCHAR(255) DEFAULT NULL, ADD person_name VARCHAR(255) DEFAULT NULL, ADD surname VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL, ADD notes LONGTEXT DEFAULT NULL, ADD pay_method INT DEFAULT NULL, ADD delivery INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE u_user DROP street, DROP house, DROP flat, DROP floor, DROP person_name, DROP surname, DROP phone, DROP notes, DROP pay_method, DROP delivery');
    }
}
