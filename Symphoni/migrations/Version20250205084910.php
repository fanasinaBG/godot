<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250205084910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, relationplat_commande_id INT DEFAULT NULL, prix_total INT NOT NULL, statue VARCHAR(255) NOT NULL, INDEX IDX_6EEAA67D197EC537 (relationplat_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, relation_ingredient_recette_id INT DEFAULT NULL, stock_ingredient_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_6BAF7870640227C8 (relation_ingredient_recette_id), INDEX IDX_6BAF787017A0CA68 (stock_ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plat (id INT AUTO_INCREMENT NOT NULL, relationplat_commande_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, INDEX IDX_2038A207197EC537 (relationplat_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, id_plat_id INT DEFAULT NULL, relation_ingredient_recette_id INT DEFAULT NULL, temps INT NOT NULL, UNIQUE INDEX UNIQ_49BB63909A01C10 (id_plat_id), INDEX IDX_49BB6390640227C8 (relation_ingredient_recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relation_ingredient_recette (id INT AUTO_INCREMENT NOT NULL, nombre INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relationplat_commande (id INT AUTO_INCREMENT NOT NULL, nombre INT NOT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_ingredient (id INT AUTO_INCREMENT NOT NULL, entre INT NOT NULL, sortie INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vilany (id INT AUTO_INCREMENT NOT NULL, recette_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_12D93C5E89312FE9 (recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D197EC537 FOREIGN KEY (relationplat_commande_id) REFERENCES relationplat_commande (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870640227C8 FOREIGN KEY (relation_ingredient_recette_id) REFERENCES relation_ingredient_recette (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787017A0CA68 FOREIGN KEY (stock_ingredient_id) REFERENCES stock_ingredient (id)');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207197EC537 FOREIGN KEY (relationplat_commande_id) REFERENCES relationplat_commande (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB63909A01C10 FOREIGN KEY (id_plat_id) REFERENCES plat (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390640227C8 FOREIGN KEY (relation_ingredient_recette_id) REFERENCES relation_ingredient_recette (id)');
        $this->addSql('ALTER TABLE vilany ADD CONSTRAINT FK_12D93C5E89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE client ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045582EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_C744045582EA2E54 ON client (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045582EA2E54');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D197EC537');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870640227C8');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF787017A0CA68');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207197EC537');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB63909A01C10');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390640227C8');
        $this->addSql('ALTER TABLE vilany DROP FOREIGN KEY FK_12D93C5E89312FE9');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE plat');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE relation_ingredient_recette');
        $this->addSql('DROP TABLE relationplat_commande');
        $this->addSql('DROP TABLE stock_ingredient');
        $this->addSql('DROP TABLE vilany');
        $this->addSql('DROP INDEX IDX_C744045582EA2E54 ON client');
        $this->addSql('ALTER TABLE client DROP commande_id');
    }
}
