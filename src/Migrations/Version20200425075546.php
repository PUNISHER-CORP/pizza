<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425075546 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dimension (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dimension_product (dimension_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_6143C6AB277428AD (dimension_id), INDEX IDX_6143C6AB4584665A (product_id), PRIMARY KEY(dimension_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_1846DB702C2AC5D3 (translatable_id), UNIQUE INDEX product_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dimension_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_F78431742C2AC5D3 (translatable_id), UNIQUE INDEX dimension_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CDFC73564584665A (product_id), INDEX IDX_CDFC735612469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dimension_product ADD CONSTRAINT FK_6143C6AB277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dimension_product ADD CONSTRAINT FK_6143C6AB4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_translation ADD CONSTRAINT FK_1846DB702C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dimension_translation ADD CONSTRAINT FK_F78431742C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES dimension (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dimension_product DROP FOREIGN KEY FK_6143C6AB277428AD');
        $this->addSql('ALTER TABLE dimension_translation DROP FOREIGN KEY FK_F78431742C2AC5D3');
        $this->addSql('ALTER TABLE dimension_product DROP FOREIGN KEY FK_6143C6AB4584665A');
        $this->addSql('ALTER TABLE product_translation DROP FOREIGN KEY FK_1846DB702C2AC5D3');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC73564584665A');
        $this->addSql('DROP TABLE dimension');
        $this->addSql('DROP TABLE dimension_product');
        $this->addSql('DROP TABLE product_translation');
        $this->addSql('DROP TABLE dimension_translation');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_category');
    }
}
