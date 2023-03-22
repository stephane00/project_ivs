<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322013454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE buildings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE organisations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pieces_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE buildings (id INT NOT NULL, o_id_id INT NOT NULL, name VARCHAR(50) NOT NULL, zipcode INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9A51B6A7A42C301A ON buildings (o_id_id)');
        $this->addSql('CREATE TABLE organisations (id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pieces (id INT NOT NULL, b_id_id INT NOT NULL, name VARCHAR(50) NOT NULL, people INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B92D7472C5FB51DA ON pieces (b_id_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE buildings ADD CONSTRAINT FK_9A51B6A7A42C301A FOREIGN KEY (o_id_id) REFERENCES organisations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pieces ADD CONSTRAINT FK_B92D7472C5FB51DA FOREIGN KEY (b_id_id) REFERENCES buildings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE buildings_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE organisations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pieces_id_seq CASCADE');
        $this->addSql('ALTER TABLE buildings DROP CONSTRAINT FK_9A51B6A7A42C301A');
        $this->addSql('ALTER TABLE pieces DROP CONSTRAINT FK_B92D7472C5FB51DA');
        $this->addSql('DROP TABLE buildings');
        $this->addSql('DROP TABLE organisations');
        $this->addSql('DROP TABLE pieces');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
