<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118140531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_profil AS SELECT id, user_id, first_name, last_name, slug, address, city, zip_code, country, phone_number, job_sought, presentation, availability, website, picture FROM user_profil');
        $this->addSql('DROP TABLE user_profil');
        $this->addSql('CREATE TABLE user_profil (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, job_sought VARCHAR(255) DEFAULT NULL, presentation CLOB NOT NULL, availability BOOLEAN DEFAULT NULL, website VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, CONSTRAINT FK_8384A9AAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_profil (id, user_id, first_name, last_name, slug, address, city, zip_code, country, phone_number, job_sought, presentation, availability, website, picture) SELECT id, user_id, first_name, last_name, slug, address, city, zip_code, country, phone_number, job_sought, presentation, availability, website, picture FROM __temp__user_profil');
        $this->addSql('DROP TABLE __temp__user_profil');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8384A9AAA76ED395 ON user_profil (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_profil AS SELECT id, user_id, first_name, last_name, slug, address, city, zip_code, country, phone_number, job_sought, presentation, availability, website, picture FROM user_profil');
        $this->addSql('DROP TABLE user_profil');
        $this->addSql('CREATE TABLE user_profil (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, job_sought VARCHAR(255) DEFAULT NULL, presentation CLOB NOT NULL, availability VARCHAR(255) DEFAULT NULL, website VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, CONSTRAINT FK_8384A9AAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_profil (id, user_id, first_name, last_name, slug, address, city, zip_code, country, phone_number, job_sought, presentation, availability, website, picture) SELECT id, user_id, first_name, last_name, slug, address, city, zip_code, country, phone_number, job_sought, presentation, availability, website, picture FROM __temp__user_profil');
        $this->addSql('DROP TABLE __temp__user_profil');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8384A9AAA76ED395 ON user_profil (user_id)');
    }
}
