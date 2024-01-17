<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240117104109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__contract_type AS SELECT id, name, slug, created_at FROM contract_type');
        $this->addSql('DROP TABLE contract_type');
        $this->addSql('CREATE TABLE contract_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO contract_type (id, name, slug, created_at) SELECT id, name, slug, created_at FROM __temp__contract_type');
        $this->addSql('DROP TABLE __temp__contract_type');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E4AB1941989D9B62 ON contract_type (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__contract_type AS SELECT id, name, slug, created_at FROM contract_type');
        $this->addSql('DROP TABLE contract_type');
        $this->addSql('CREATE TABLE contract_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO contract_type (id, name, slug, created_at) SELECT id, name, slug, created_at FROM __temp__contract_type');
        $this->addSql('DROP TABLE __temp__contract_type');
    }
}
