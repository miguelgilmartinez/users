<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210715182141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient_users (patient_users_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', user BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', patient_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_81B57E268D93D649 (user), PRIMARY KEY(patient_users_uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (user_uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(100) DEFAULT NULL, saga_status VARCHAR(100) DEFAULT NULL, health_worker BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', PRIMARY KEY(user_uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient_users ADD CONSTRAINT FK_81B57E268D93D649 FOREIGN KEY (user) REFERENCES user (user_uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient_users DROP FOREIGN KEY FK_81B57E268D93D649');
        $this->addSql('DROP TABLE patient_users');
        $this->addSql('DROP TABLE user');
    }
}
