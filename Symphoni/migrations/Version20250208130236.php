<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250208130236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock_ingredient CHANGE ingredient_id ingredient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock_ingredient ADD CONSTRAINT FK_C5E68FDC933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('CREATE INDEX IDX_C5E68FDC933FE08C ON stock_ingredient (ingredient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock_ingredient DROP FOREIGN KEY FK_C5E68FDC933FE08C');
        $this->addSql('DROP INDEX IDX_C5E68FDC933FE08C ON stock_ingredient');
        $this->addSql('ALTER TABLE stock_ingredient CHANGE ingredient_id ingredient_id INT NOT NULL');
    }
}
