<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425112550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dimensions_products (id INT AUTO_INCREMENT NOT NULL, dimension_id INT DEFAULT NULL, product_id INT DEFAULT NULL, INDEX IDX_EB2B4A77277428AD (dimension_id), INDEX IDX_EB2B4A774584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dimensions_products_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, price VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_813F39902C2AC5D3 (translatable_id), UNIQUE INDEX dimensions_products_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dimensions_products ADD CONSTRAINT FK_EB2B4A77277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id)');
        $this->addSql('ALTER TABLE dimensions_products ADD CONSTRAINT FK_EB2B4A774584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE dimensions_products_translation ADD CONSTRAINT FK_813F39902C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES dimensions_products (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE product_dimension');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dimensions_products_translation DROP FOREIGN KEY FK_813F39902C2AC5D3');
        $this->addSql('CREATE TABLE product_dimension (product_id INT NOT NULL, dimension_id INT NOT NULL, INDEX IDX_A43B77114584665A (product_id), INDEX IDX_A43B7711277428AD (dimension_id), PRIMARY KEY(product_id, dimension_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_dimension ADD CONSTRAINT FK_A43B7711277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_dimension ADD CONSTRAINT FK_A43B77114584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE dimensions_products');
        $this->addSql('DROP TABLE dimensions_products_translation');
    }
}
