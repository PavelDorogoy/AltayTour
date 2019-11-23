<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191123184528 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `equipments` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, count INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `equipment_reservations` (id INT AUTO_INCREMENT NOT NULL, reservation_tour_id INT NOT NULL, equipment_id INT NOT NULL, count INT NOT NULL, INDEX IDX_A52655A6727836C6 (reservation_tour_id), INDEX IDX_A52655A6517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `tours` (id INT AUTO_INCREMENT NOT NULL, instructor_id INT DEFAULT NULL, route_id INT NOT NULL, date DATE NOT NULL, count_person INT NOT NULL, INDEX IDX_2F0AC70E8C4FC193 (instructor_id), INDEX IDX_2F0AC70E34ECB4E6 (route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `tour_equipments` (id INT AUTO_INCREMENT NOT NULL, tour_id INT NOT NULL, equipment_id INT NOT NULL, count INT NOT NULL, INDEX IDX_89B033DB15ED8D43 (tour_id), INDEX IDX_89B033DB517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `routes` (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(45) NOT NULL, description LONGTEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, distance DOUBLE PRECISION NOT NULL, days INT NOT NULL, INDEX IDX_32D5C2B3C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `route_photo_albums` (id INT AUTO_INCREMENT NOT NULL, route_id INT NOT NULL, name VARCHAR(45) NOT NULL, photos_json JSON DEFAULT NULL, INDEX IDX_CBD3709534ECB4E6 (route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `route_points` (id INT AUTO_INCREMENT NOT NULL, route_id INT NOT NULL, day INT NOT NULL, logo VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, lon DOUBLE PRECISION DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, INDEX IDX_16497FF434ECB4E6 (route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `route_types` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `tour_reservations` (id INT AUTO_INCREMENT NOT NULL, tour_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_240676115ED8D43 (tour_id), INDEX IDX_2406761A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(15) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, is_active TINYINT(1) NOT NULL, is_confirmed TINYINT(1) NOT NULL, confirmation_code VARCHAR(20) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `equipment_reservations` ADD CONSTRAINT FK_A52655A6727836C6 FOREIGN KEY (reservation_tour_id) REFERENCES `tour_reservations` (id)');
        $this->addSql('ALTER TABLE `equipment_reservations` ADD CONSTRAINT FK_A52655A6517FE9FE FOREIGN KEY (equipment_id) REFERENCES `equipments` (id)');
        $this->addSql('ALTER TABLE `tours` ADD CONSTRAINT FK_2F0AC70E8C4FC193 FOREIGN KEY (instructor_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `tours` ADD CONSTRAINT FK_2F0AC70E34ECB4E6 FOREIGN KEY (route_id) REFERENCES `routes` (id)');
        $this->addSql('ALTER TABLE `tour_equipments` ADD CONSTRAINT FK_89B033DB15ED8D43 FOREIGN KEY (tour_id) REFERENCES `tours` (id)');
        $this->addSql('ALTER TABLE `tour_equipments` ADD CONSTRAINT FK_89B033DB517FE9FE FOREIGN KEY (equipment_id) REFERENCES `equipments` (id)');
        $this->addSql('ALTER TABLE `routes` ADD CONSTRAINT FK_32D5C2B3C54C8C93 FOREIGN KEY (type_id) REFERENCES `route_types` (id)');
        $this->addSql('ALTER TABLE `route_photo_albums` ADD CONSTRAINT FK_CBD3709534ECB4E6 FOREIGN KEY (route_id) REFERENCES `routes` (id)');
        $this->addSql('ALTER TABLE `route_points` ADD CONSTRAINT FK_16497FF434ECB4E6 FOREIGN KEY (route_id) REFERENCES `routes` (id)');
        $this->addSql('ALTER TABLE `tour_reservations` ADD CONSTRAINT FK_240676115ED8D43 FOREIGN KEY (tour_id) REFERENCES `tours` (id)');
        $this->addSql('ALTER TABLE `tour_reservations` ADD CONSTRAINT FK_2406761A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `equipment_reservations` DROP FOREIGN KEY FK_A52655A6517FE9FE');
        $this->addSql('ALTER TABLE `tour_equipments` DROP FOREIGN KEY FK_89B033DB517FE9FE');
        $this->addSql('ALTER TABLE `tour_equipments` DROP FOREIGN KEY FK_89B033DB15ED8D43');
        $this->addSql('ALTER TABLE `tour_reservations` DROP FOREIGN KEY FK_240676115ED8D43');
        $this->addSql('ALTER TABLE `tours` DROP FOREIGN KEY FK_2F0AC70E34ECB4E6');
        $this->addSql('ALTER TABLE `route_photo_albums` DROP FOREIGN KEY FK_CBD3709534ECB4E6');
        $this->addSql('ALTER TABLE `route_points` DROP FOREIGN KEY FK_16497FF434ECB4E6');
        $this->addSql('ALTER TABLE `routes` DROP FOREIGN KEY FK_32D5C2B3C54C8C93');
        $this->addSql('ALTER TABLE `equipment_reservations` DROP FOREIGN KEY FK_A52655A6727836C6');
        $this->addSql('ALTER TABLE `tours` DROP FOREIGN KEY FK_2F0AC70E8C4FC193');
        $this->addSql('ALTER TABLE `tour_reservations` DROP FOREIGN KEY FK_2406761A76ED395');
        $this->addSql('DROP TABLE `equipments`');
        $this->addSql('DROP TABLE `equipment_reservations`');
        $this->addSql('DROP TABLE `tours`');
        $this->addSql('DROP TABLE `tour_equipments`');
        $this->addSql('DROP TABLE `routes`');
        $this->addSql('DROP TABLE `route_photo_albums`');
        $this->addSql('DROP TABLE `route_points`');
        $this->addSql('DROP TABLE `route_types`');
        $this->addSql('DROP TABLE `tour_reservations`');
        $this->addSql('DROP TABLE `users`');
    }
}
