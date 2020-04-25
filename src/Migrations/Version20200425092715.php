<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425092715 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_dimension (product_id INT NOT NULL, dimension_id INT NOT NULL, INDEX IDX_A43B77114584665A (product_id), INDEX IDX_A43B7711277428AD (dimension_id), PRIMARY KEY(product_id, dimension_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_dimension ADD CONSTRAINT FK_A43B77114584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_dimension ADD CONSTRAINT FK_A43B7711277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE dimension_product');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dimension_product (dimension_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_6143C6AB277428AD (dimension_id), INDEX IDX_6143C6AB4584665A (product_id), PRIMARY KEY(dimension_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE dimension_product ADD CONSTRAINT FK_6143C6AB277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dimension_product ADD CONSTRAINT FK_6143C6AB4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE product_dimension');
    }
}
