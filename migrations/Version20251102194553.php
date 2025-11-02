<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251102194553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT NOT NULL, id_enclo_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, date_arrive DATE NOT NULL, date_depart DATE DEFAULT NULL, genre VARCHAR(50) NOT NULL, espece VARCHAR(255) NOT NULL, sterilise TINYINT(1) NOT NULL, quarantaine TINYINT(1) NOT NULL, INDEX IDX_6AAB231F5E9CB654 (id_enclo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enclo (id INT AUTO_INCREMENT NOT NULL, id_espace_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, superficie INT NOT NULL, capacite INT NOT NULL, quarantaine TINYINT(1) NOT NULL, INDEX IDX_12DDA20B36BDE04B (id_espace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE espace (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, superficie INT NOT NULL, date_ouverture DATE DEFAULT NULL, date_fermeture DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F5E9CB654 FOREIGN KEY (id_enclo_id) REFERENCES enclo (id)');
        $this->addSql('ALTER TABLE enclo ADD CONSTRAINT FK_12DDA20B36BDE04B FOREIGN KEY (id_espace_id) REFERENCES espace (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F5E9CB654');
        $this->addSql('ALTER TABLE enclo DROP FOREIGN KEY FK_12DDA20B36BDE04B');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE enclo');
        $this->addSql('DROP TABLE espace');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
