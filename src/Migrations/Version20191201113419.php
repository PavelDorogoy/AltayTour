<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191201113419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE equipment_reservations DROP FOREIGN KEY FK_A52655A6517FE9FE');
        $this->addSql('ALTER TABLE equipment_reservations DROP FOREIGN KEY FK_A52655A6727836C6');
        $this->addSql('ALTER TABLE equipment_reservations ADD CONSTRAINT FK_A52655A6517FE9FE FOREIGN KEY (equipment_id) REFERENCES `equipments` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_reservations ADD CONSTRAINT FK_A52655A6727836C6 FOREIGN KEY (reservation_tour_id) REFERENCES `tour_reservations` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `equipment_reservations` DROP FOREIGN KEY FK_A52655A6727836C6');
        $this->addSql('ALTER TABLE `equipment_reservations` DROP FOREIGN KEY FK_A52655A6517FE9FE');
        $this->addSql('ALTER TABLE `equipment_reservations` ADD CONSTRAINT FK_A52655A6727836C6 FOREIGN KEY (reservation_tour_id) REFERENCES tour_reservations (id)');
        $this->addSql('ALTER TABLE `equipment_reservations` ADD CONSTRAINT FK_A52655A6517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipments (id)');
    }
}
