<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621122511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basket (item_id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, customer_id INT NOT NULL,
        product_id INT NOT NULL, INDEX IDX_2246507B9395C3F3 (customer_id), INDEX IDX_2246507B4584665A (product_id), PRIMARY KEY(item_id)) DEFAULT CHARACTER SET utf8');

        $this->addSql('CREATE TABLE `order` (order_id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, phone VARCHAR(255) NOT NULL,
        adress VARCHAR(255) NOT NULL, customer_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_F52993989395C3F3 (customer_id),
        INDEX IDX_F52993984584665A (product_id), PRIMARY KEY(order_id)) DEFAULT CHARACTER SET utf8');

        $this->addSql('CREATE TABLE product (product_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, ingredients VARCHAR(255) NOT NULL,
        discription VARCHAR(255) NOT NULL, calories VARCHAR(255) NOT NULL, proteins INT NOT NULL, fats VARCHAR(255) NOT NULL, carbs VARCHAR(255) NOT NULL,
        price VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, PRIMARY KEY(product_id)) DEFAULT CHARACTER SET utf8');

        $this->addSql('CREATE TABLE user (user_id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, `password` VARCHAR(255) DEFAULT NULL,
        first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL NULL, phone VARCHAR(255) DEFAULT NULL, adress VARCHAR(255) DEFAULT NULL,
        avatar_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8');

        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507B9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507B4584665A FOREIGN KEY (product_id) REFERENCES product (product_id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984584665A FOREIGN KEY (product_id) REFERENCES product (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507B9395C3F3');
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507B4584665A');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984584665A');
        $this->addSql('DROP TABLE basket');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE user');
    }
}
