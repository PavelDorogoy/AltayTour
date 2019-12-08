<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191208091043 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE album_images (album_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_326483DD1137ABCF (album_id), UNIQUE INDEX UNIQ_326483DD3DA5256D (image_id), PRIMARY KEY(album_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `route_photo_albums_image` (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album_images ADD CONSTRAINT FK_326483DD1137ABCF FOREIGN KEY (album_id) REFERENCES `route_photo_albums` (id)');
        $this->addSql('ALTER TABLE album_images ADD CONSTRAINT FK_326483DD3DA5256D FOREIGN KEY (image_id) REFERENCES `route_photo_albums_image` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE album_images DROP FOREIGN KEY FK_326483DD3DA5256D');
        $this->addSql('DROP TABLE album_images');
        $this->addSql('DROP TABLE `route_photo_albums_image`');
    }
}
