<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329074708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE theme_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE theme (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE theme_user (theme_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(theme_id, user_id))');
        $this->addSql('CREATE INDEX IDX_C754227459027487 ON theme_user (theme_id)');
        $this->addSql('CREATE INDEX IDX_C7542274A76ED395 ON theme_user (user_id)');
        $this->addSql('CREATE TABLE theme_content (theme_id INT NOT NULL, content_id INT NOT NULL, PRIMARY KEY(theme_id, content_id))');
        $this->addSql('CREATE INDEX IDX_A7A6358A59027487 ON theme_content (theme_id)');
        $this->addSql('CREATE INDEX IDX_A7A6358A84A0A3ED ON theme_content (content_id)');
        $this->addSql('ALTER TABLE theme_user ADD CONSTRAINT FK_C754227459027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_user ADD CONSTRAINT FK_C7542274A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_content ADD CONSTRAINT FK_A7A6358A59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_content ADD CONSTRAINT FK_A7A6358A84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE theme_user DROP CONSTRAINT FK_C754227459027487');
        $this->addSql('ALTER TABLE theme_content DROP CONSTRAINT FK_A7A6358A59027487');
        $this->addSql('DROP SEQUENCE theme_id_seq CASCADE');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE theme_user');
        $this->addSql('DROP TABLE theme_content');
    }
}
