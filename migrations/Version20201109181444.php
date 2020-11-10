<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201109181444 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account_provider (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE bank_account (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, provider_id INTEGER DEFAULT NULL, business_id INTEGER NOT NULL, bic VARCHAR(255) NOT NULL, iban VARCHAR(255) NOT NULL, reference VARCHAR(255) DEFAULT NULL, currencies CLOB NOT NULL --(DC2Type:array)
        , active BOOLEAN NOT NULL, public BOOLEAN NOT NULL, note CLOB DEFAULT NULL, internal_note CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_53A23E0AFAD56E62 ON bank_account (iban)');
        $this->addSql('CREATE INDEX IDX_53A23E0AA53A8AA ON bank_account (provider_id)');
        $this->addSql('CREATE INDEX IDX_53A23E0AA89DB457 ON bank_account (business_id)');
        $this->addSql('CREATE TABLE business (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, incorporated_at DATE NOT NULL, description CLOB DEFAULT NULL, registry_url VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, vat VARCHAR(255) DEFAULT NULL, identification_number VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, address_street VARCHAR(255) DEFAULT NULL, address_postal_code VARCHAR(255) DEFAULT NULL, address_city VARCHAR(255) DEFAULT NULL, address_country VARCHAR(2) DEFAULT NULL, phone_number VARCHAR(16) DEFAULT NULL, phone_country VARCHAR(2) DEFAULT NULL)');
        $this->addSql('CREATE TABLE crypto_currency_account (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, provider_id INTEGER DEFAULT NULL, business_id INTEGER NOT NULL, currency VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, public BOOLEAN NOT NULL, note CLOB DEFAULT NULL, internal_note CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DB9879AFD4E6F81 ON crypto_currency_account (address)');
        $this->addSql('CREATE INDEX IDX_DB9879AFA53A8AA ON crypto_currency_account (provider_id)');
        $this->addSql('CREATE INDEX IDX_DB9879AFA89DB457 ON crypto_currency_account (business_id)');
        $this->addSql('CREATE TABLE envelope (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, message CLOB NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE service_account (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, provider_id INTEGER NOT NULL, business_id INTEGER NOT NULL, identifier VARCHAR(255) NOT NULL, currencies CLOB NOT NULL --(DC2Type:array)
        , active BOOLEAN NOT NULL, public BOOLEAN NOT NULL, note CLOB DEFAULT NULL, internal_note CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_B2B20438A53A8AA ON service_account (provider_id)');
        $this->addSql('CREATE INDEX IDX_B2B20438A89DB457 ON service_account (business_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B2B20438772E836AA53A8AA ON service_account (identifier, provider_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE account_provider');
        $this->addSql('DROP TABLE bank_account');
        $this->addSql('DROP TABLE business');
        $this->addSql('DROP TABLE crypto_currency_account');
        $this->addSql('DROP TABLE envelope');
        $this->addSql('DROP TABLE service_account');
        $this->addSql('DROP TABLE user');
    }
}
