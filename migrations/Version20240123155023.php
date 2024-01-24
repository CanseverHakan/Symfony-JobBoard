<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123155023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, entreprise_id INTEGER DEFAULT NULL, offer_id INTEGER DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , message CLOB NOT NULL, CONSTRAINT FK_A45BDDC1A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A45BDDC1A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise_profil (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A45BDDC153C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_A45BDDC1A76ED395 ON application (user_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC1A4AEAFEA ON application (entreprise_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC153C674EE ON application (offer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE application');
    }
}
