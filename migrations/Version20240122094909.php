<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122094909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contract_type_id INTEGER DEFAULT NULL, entreprise_id INTEGER DEFAULT NULL, tags_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, short_description VARCHAR(255) NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , salary INTEGER NOT NULL, location VARCHAR(255) NOT NULL, is_active BOOLEAN DEFAULT NULL, CONSTRAINT FK_29D6873ECD1DF15B FOREIGN KEY (contract_type_id) REFERENCES contract_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_29D6873EA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise_profil (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_29D6873E8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_29D6873ECD1DF15B ON offer (contract_type_id)');
        $this->addSql('CREATE INDEX IDX_29D6873EA4AEAFEA ON offer (entreprise_id)');
        $this->addSql('CREATE INDEX IDX_29D6873E8D7B4FB4 ON offer (tags_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE offer');
    }
}
