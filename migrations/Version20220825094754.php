<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220825094754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bank AS SELECT id, balance FROM bank');
        $this->addSql('DROP TABLE bank');
        $this->addSql('CREATE TABLE bank (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username_id INTEGER NOT NULL, balance INTEGER DEFAULT NULL, CONSTRAINT FK_D860BF7AED766068 FOREIGN KEY (username_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bank (id, balance) SELECT id, balance FROM __temp__bank');
        $this->addSql('DROP TABLE __temp__bank');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D860BF7AED766068 ON bank (username_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('DROP INDEX UNIQ_8D93D64911C8FB41');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, bank_id, username, roles, password, firstname, lastname, image FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bank_id INTEGER DEFAULT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_8D93D64911C8FB41 FOREIGN KEY (bank_id) REFERENCES bank (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, bank_id, username, roles, password, firstname, lastname, image) SELECT id, bank_id, username, roles, password, firstname, lastname, image FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64911C8FB41 ON user (bank_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_D860BF7AED766068');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bank AS SELECT id, balance FROM bank');
        $this->addSql('DROP TABLE bank');
        $this->addSql('CREATE TABLE bank (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, balance INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO bank (id, balance) SELECT id, balance FROM __temp__bank');
        $this->addSql('DROP TABLE __temp__bank');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('DROP INDEX UNIQ_8D93D64911C8FB41');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, bank_id, username, roles, password, firstname, lastname, image FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bank_id INTEGER DEFAULT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, bank_id, username, roles, password, firstname, lastname, image) SELECT id, bank_id, username, roles, password, firstname, lastname, image FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64911C8FB41 ON user (bank_id)');
    }
}
