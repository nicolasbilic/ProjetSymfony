<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218110418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, street VARCHAR(255) NOT NULL, additional VARCHAR(255) DEFAULT NULL, city VARCHAR(50) NOT NULL, zip_code INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE basket (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, INDEX IDX_2246507B9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE basket_line (id INT AUTO_INCREMENT NOT NULL, basket_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_1A9BADC31BE1FB52 (basket_id), INDEX IDX_1A9BADC34584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(500) DEFAULT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_81398E09E7927C74 (email), INDEX IDX_81398E09F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, basket_id INT NOT NULL, order_state_id INT NOT NULL, shipping_address_id INT NOT NULL, invoice_address_id INT NOT NULL, customer_id INT NOT NULL, total DOUBLE PRECISION NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', shipping_price DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_F52993981BE1FB52 (basket_id), INDEX IDX_F5299398E420DE70 (order_state_id), INDEX IDX_F52993984D4CFF2B (shipping_address_id), INDEX IDX_F5299398C6BDFEB (invoice_address_id), INDEX IDX_F52993989395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, order_customer_id INT NOT NULL, quantity INT NOT NULL, product_name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, tva DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_9CE58EE18827BC75 (order_customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_state (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, tva_id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(500) DEFAULT NULL, discount DOUBLE PRECISION DEFAULT NULL, stock INT NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD4D79775F (tva_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tva (id INT AUTO_INCREMENT NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507B9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE basket_line ADD CONSTRAINT FK_1A9BADC31BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('ALTER TABLE basket_line ADD CONSTRAINT FK_1A9BADC34584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993981BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398E420DE70 FOREIGN KEY (order_state_id) REFERENCES order_state (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984D4CFF2B FOREIGN KEY (shipping_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398C6BDFEB FOREIGN KEY (invoice_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE18827BC75 FOREIGN KEY (order_customer_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4D79775F FOREIGN KEY (tva_id) REFERENCES tva (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507B9395C3F3');
        $this->addSql('ALTER TABLE basket_line DROP FOREIGN KEY FK_1A9BADC31BE1FB52');
        $this->addSql('ALTER TABLE basket_line DROP FOREIGN KEY FK_1A9BADC34584665A');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09F5B7AF75');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993981BE1FB52');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398E420DE70');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984D4CFF2B');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398C6BDFEB');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE18827BC75');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4D79775F');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE basket');
        $this->addSql('DROP TABLE basket_line');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE order_state');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE tva');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
