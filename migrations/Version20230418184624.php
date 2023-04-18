<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418184624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_page CHANGE advantage1 advantage1 LONGTEXT DEFAULT NULL, CHANGE advantage2 advantage2 LONGTEXT DEFAULT NULL, CHANGE advantage3 advantage3 LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_page CHANGE advantage1 advantage1 VARCHAR(255) NOT NULL, CHANGE advantage2 advantage2 VARCHAR(255) NOT NULL, CHANGE advantage3 advantage3 VARCHAR(255) NOT NULL');
    }
}
