<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615180352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aircraft_maintenance_service_entity ADD is_visible TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE consult_aircraft_service_entity ADD is_visible TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE flight_service_entity ADD is_visible TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aircraft_maintenance_service_entity DROP is_visible');
        $this->addSql('ALTER TABLE consult_aircraft_service_entity DROP is_visible');
        $this->addSql('ALTER TABLE flight_service_entity DROP is_visible');
    }
}
