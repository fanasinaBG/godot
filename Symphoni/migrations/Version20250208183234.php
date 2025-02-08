<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250208183234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE relationplat_commande ADD CONSTRAINT FK_F75E9A4D82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE relationplat_commande ADD CONSTRAINT FK_F75E9A4DD73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id)');
        $this->addSql('CREATE INDEX IDX_F75E9A4D82EA2E54 ON relationplat_commande (commande_id)');
        $this->addSql('CREATE INDEX IDX_F75E9A4DD73DB560 ON relationplat_commande (plat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE relationplat_commande DROP FOREIGN KEY FK_F75E9A4D82EA2E54');
        $this->addSql('ALTER TABLE relationplat_commande DROP FOREIGN KEY FK_F75E9A4DD73DB560');
        $this->addSql('DROP INDEX IDX_F75E9A4D82EA2E54 ON relationplat_commande');
        $this->addSql('DROP INDEX IDX_F75E9A4DD73DB560 ON relationplat_commande');
    }
}
