<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231217151859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP id_address');
        $this->addSql('ALTER TABLE `admin` DROP id_admin');
        $this->addSql('ALTER TABLE basket DROP id_basket');
        $this->addSql('ALTER TABLE basket_line DROP id_basket_line');
        $this->addSql('ALTER TABLE category DROP id_category');
        $this->addSql('ALTER TABLE customer DROP id_customer');
        $this->addSql('ALTER TABLE `order` DROP id_order');
        $this->addSql('ALTER TABLE order_line DROP id_order_line');
        $this->addSql('ALTER TABLE order_state DROP id_order_state');
        $this->addSql('ALTER TABLE product DROP id_product');
        $this->addSql('ALTER TABLE role DROP id_role');
        $this->addSql('ALTER TABLE tva DROP id_tva');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD id_address INT NOT NULL');
        $this->addSql('ALTER TABLE `admin` ADD id_admin INT NOT NULL');
        $this->addSql('ALTER TABLE basket ADD id_basket INT NOT NULL');
        $this->addSql('ALTER TABLE basket_line ADD id_basket_line INT NOT NULL');
        $this->addSql('ALTER TABLE category ADD id_category INT NOT NULL');
        $this->addSql('ALTER TABLE customer ADD id_customer INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD id_order INT NOT NULL');
        $this->addSql('ALTER TABLE order_line ADD id_order_line INT NOT NULL');
        $this->addSql('ALTER TABLE order_state ADD id_order_state INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD id_product INT NOT NULL');
        $this->addSql('ALTER TABLE role ADD id_role INT NOT NULL');
        $this->addSql('ALTER TABLE tva ADD id_tva INT NOT NULL');
    }
}
