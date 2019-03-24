<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190324222842 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, picture, firstname, lastname, street, zip, city, country, phonenumber, birthday, email FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, picture VARCHAR(255) NOT NULL COLLATE BINARY, firstname CLOB NOT NULL COLLATE BINARY, lastname CLOB NOT NULL COLLATE BINARY, street CLOB NOT NULL COLLATE BINARY, zip INTEGER NOT NULL, city CLOB NOT NULL COLLATE BINARY, country CLOB NOT NULL COLLATE BINARY, phonenumber INTEGER NOT NULL, birthday INTEGER NOT NULL, email CLOB NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO contact (id, picture, firstname, lastname, street, zip, city, country, phonenumber, birthday, email) SELECT id, picture, firstname, lastname, street, zip, city, country, phonenumber, birthday, email FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE contact ADD COLUMN text VARCHAR(255) NOT NULL COLLATE BINARY');
    }
}
