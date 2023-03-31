<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331173334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE content_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE opinion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE theme_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE content (id INT NOT NULL, author_id INT NOT NULL, name VARCHAR(100) NOT NULL, status VARCHAR(20) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FEC530A9F675F31B ON content (author_id)');
        $this->addSql('CREATE TABLE content_user (content_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(content_id, user_id))');
        $this->addSql('CREATE INDEX IDX_40F13B8C84A0A3ED ON content_user (content_id)');
        $this->addSql('CREATE INDEX IDX_40F13B8CA76ED395 ON content_user (user_id)');
        $this->addSql('CREATE TABLE media (id INT NOT NULL, content_id INT NOT NULL, type_id INT NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6A2CA10C84A0A3ED ON media (content_id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10CC54C8C93 ON media (type_id)');
        $this->addSql('CREATE TABLE opinion (id INT NOT NULL, author_id INT NOT NULL, content_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, text TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AB02B027F675F31B ON opinion (author_id)');
        $this->addSql('CREATE INDEX IDX_AB02B02784A0A3ED ON opinion (content_id)');
        $this->addSql('CREATE TABLE opinion_user (opinion_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(opinion_id, user_id))');
        $this->addSql('CREATE INDEX IDX_F052AA9051885A6A ON opinion_user (opinion_id)');
        $this->addSql('CREATE INDEX IDX_F052AA90A76ED395 ON opinion_user (user_id)');
        $this->addSql('CREATE TABLE theme (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE theme_user (theme_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(theme_id, user_id))');
        $this->addSql('CREATE INDEX IDX_C754227459027487 ON theme_user (theme_id)');
        $this->addSql('CREATE INDEX IDX_C7542274A76ED395 ON theme_user (user_id)');
        $this->addSql('CREATE TABLE theme_content (theme_id INT NOT NULL, content_id INT NOT NULL, PRIMARY KEY(theme_id, content_id))');
        $this->addSql('CREATE INDEX IDX_A7A6358A59027487 ON theme_content (theme_id)');
        $this->addSql('CREATE INDEX IDX_A7A6358A84A0A3ED ON theme_content (content_id)');
        $this->addSql('CREATE TABLE type_media (id INT NOT NULL, name VARCHAR(30) NOT NULL, extensions TEXT DEFAULT NULL, slug VARCHAR(30) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN type_media.extensions IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE content_user ADD CONSTRAINT FK_40F13B8C84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE content_user ADD CONSTRAINT FK_40F13B8CA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CC54C8C93 FOREIGN KEY (type_id) REFERENCES type_media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B02784A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opinion_user ADD CONSTRAINT FK_F052AA9051885A6A FOREIGN KEY (opinion_id) REFERENCES opinion (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opinion_user ADD CONSTRAINT FK_F052AA90A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_user ADD CONSTRAINT FK_C754227459027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_user ADD CONSTRAINT FK_C7542274A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_content ADD CONSTRAINT FK_A7A6358A59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_content ADD CONSTRAINT FK_A7A6358A84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE content_user DROP CONSTRAINT FK_40F13B8C84A0A3ED');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10C84A0A3ED');
        $this->addSql('ALTER TABLE opinion DROP CONSTRAINT FK_AB02B02784A0A3ED');
        $this->addSql('ALTER TABLE theme_content DROP CONSTRAINT FK_A7A6358A84A0A3ED');
        $this->addSql('ALTER TABLE opinion_user DROP CONSTRAINT FK_F052AA9051885A6A');
        $this->addSql('ALTER TABLE theme_user DROP CONSTRAINT FK_C754227459027487');
        $this->addSql('ALTER TABLE theme_content DROP CONSTRAINT FK_A7A6358A59027487');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10CC54C8C93');
        $this->addSql('ALTER TABLE content DROP CONSTRAINT FK_FEC530A9F675F31B');
        $this->addSql('ALTER TABLE content_user DROP CONSTRAINT FK_40F13B8CA76ED395');
        $this->addSql('ALTER TABLE opinion DROP CONSTRAINT FK_AB02B027F675F31B');
        $this->addSql('ALTER TABLE opinion_user DROP CONSTRAINT FK_F052AA90A76ED395');
        $this->addSql('ALTER TABLE theme_user DROP CONSTRAINT FK_C7542274A76ED395');
        $this->addSql('DROP SEQUENCE content_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE opinion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE theme_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE content_user');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE opinion');
        $this->addSql('DROP TABLE opinion_user');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE theme_user');
        $this->addSql('DROP TABLE theme_content');
        $this->addSql('DROP TABLE type_media');
        $this->addSql('DROP TABLE "user"');
    }
}
