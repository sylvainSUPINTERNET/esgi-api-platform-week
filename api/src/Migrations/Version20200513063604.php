<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200513063604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE apply_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE invit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media_object_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE greeting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE apply (id INT NOT NULL, offre_id INT DEFAULT NULL, profile_picture_id INT DEFAULT NULL, cv_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, motivation TEXT NOT NULL, salary VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BD2F8C1F4CC8505A ON apply (offre_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BD2F8C1F292E8AE2 ON apply (profile_picture_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BD2F8C1FCFE419E2 ON apply (cv_id)');
        $this->addSql('CREATE TABLE invit (id INT NOT NULL, token VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE media_object (id INT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE greeting (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE offre (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, company_description VARCHAR(255) NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, working_place VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT FK_BD2F8C1F4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT FK_BD2F8C1F292E8AE2 FOREIGN KEY (profile_picture_id) REFERENCES media_object (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE apply ADD CONSTRAINT FK_BD2F8C1FCFE419E2 FOREIGN KEY (cv_id) REFERENCES media_object (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE apply DROP CONSTRAINT FK_BD2F8C1F292E8AE2');
        $this->addSql('ALTER TABLE apply DROP CONSTRAINT FK_BD2F8C1FCFE419E2');
        $this->addSql('ALTER TABLE apply DROP CONSTRAINT FK_BD2F8C1F4CC8505A');
        $this->addSql('DROP SEQUENCE apply_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE invit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE media_object_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE greeting_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offre_id_seq CASCADE');
        $this->addSql('DROP TABLE apply');
        $this->addSql('DROP TABLE invit');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP TABLE greeting');
        $this->addSql('DROP TABLE offre');
    }
}
