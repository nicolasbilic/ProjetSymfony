<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231217145347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id_address INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, street VARCHAR(255) NOT NULL, additional VARCHAR(255) DEFAULT NULL, city VARCHAR(50) NOT NULL, zip_code INT NOT NULL, PRIMARY KEY(id_address)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `admin` (id_admin INT AUTO_INCREMENT NOT NULL, id_role INT NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, mail VARCHAR(255) NOT NULL, INDEX IDX_880E0D76DC499668 (id_role), PRIMARY KEY(id_admin)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE basket (id_basket INT AUTO_INCREMENT NOT NULL, id_customer INT NOT NULL, INDEX IDX_2246507BD1E2629C (id_customer), PRIMARY KEY(id_basket)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE basket_line (id_basket_line INT AUTO_INCREMENT NOT NULL, id_basket INT NOT NULL, id_product INT NOT NULL, quantity INT NOT NULL, INDEX IDX_1A9BADC3471E596 (id_basket), INDEX IDX_1A9BADC3DD7ADDD (id_product), PRIMARY KEY(id_basket_line)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id_category INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id_category)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id_customer INT AUTO_INCREMENT NOT NULL, id_address INT DEFAULT NULL, mail VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, INDEX IDX_81398E09D3D3C6F1 (id_address), PRIMARY KEY(id_customer)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id_order INT AUTO_INCREMENT NOT NULL, id_customer INT NOT NULL, id_basket INT NOT NULL, id_order_state INT NOT NULL, id_address INT NOT NULL, total DOUBLE PRECISION NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', shipping_price DOUBLE PRECISION NOT NULL, INDEX IDX_F5299398D1E2629C (id_customer), UNIQUE INDEX UNIQ_F5299398471E596 (id_basket), INDEX IDX_F5299398381F6BF1 (id_order_state), INDEX IDX_F5299398D3D3C6F1 (id_address), PRIMARY KEY(id_order)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line (id_order_line INT AUTO_INCREMENT NOT NULL, id_order INT NOT NULL, quantity INT NOT NULL, product_name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, tva DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_9CE58EE11BACD2A8 (id_order), PRIMARY KEY(id_order_line)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_state (id_order_state INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id_order_state)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id_product INT AUTO_INCREMENT NOT NULL, id_category INT NOT NULL, id_tva INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(500) DEFAULT NULL, discount DOUBLE PRECISION DEFAULT NULL, stock INT NOT NULL, INDEX IDX_D34A04AD5697F554 (id_category), INDEX IDX_D34A04AD71CD7E7A (id_tva), PRIMARY KEY(id_product)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id_role INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id_role)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tva (id_tva INT AUTO_INCREMENT NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id_tva)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D76DC499668 FOREIGN KEY (id_role) REFERENCES role (id_role)');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507BD1E2629C FOREIGN KEY (id_customer) REFERENCES customer (id_customer)');
        $this->addSql('ALTER TABLE basket_line ADD CONSTRAINT FK_1A9BADC3471E596 FOREIGN KEY (id_basket) REFERENCES basket (id_basket)');
        $this->addSql('ALTER TABLE basket_line ADD CONSTRAINT FK_1A9BADC3DD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C15697F554 FOREIGN KEY (id_category) REFERENCES category (id_category)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09D3D3C6F1 FOREIGN KEY (id_address) REFERENCES address (id_address)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398D1E2629C FOREIGN KEY (id_customer) REFERENCES customer (id_customer)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398471E596 FOREIGN KEY (id_basket) REFERENCES basket (id_basket)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398381F6BF1 FOREIGN KEY (id_order_state) REFERENCES order_state (id_order_state)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398D3D3C6F1 FOREIGN KEY (id_address) REFERENCES address (id_address)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE11BACD2A8 FOREIGN KEY (id_order) REFERENCES `order` (id_order)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD5697F554 FOREIGN KEY (id_category) REFERENCES category (id_category)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD71CD7E7A FOREIGN KEY (id_tva) REFERENCES tva (id_tva)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D76DC499668');
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507BD1E2629C');
        $this->addSql('ALTER TABLE basket_line DROP FOREIGN KEY FK_1A9BADC3471E596');
        $this->addSql('ALTER TABLE basket_line DROP FOREIGN KEY FK_1A9BADC3DD7ADDD');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C15697F554');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09D3D3C6F1');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398D1E2629C');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398471E596');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398381F6BF1');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398D3D3C6F1');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE11BACD2A8');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD5697F554');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD71CD7E7A');
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
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE tva');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
