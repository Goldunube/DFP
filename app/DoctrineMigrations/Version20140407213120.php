<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140407213120 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE filie_procesy_aplikacji CHANGE proces_aplikacji_id proces_aplikacji_id INT NOT NULL, CHANGE filia_id filia_id INT NOT NULL");
        $this->addSql("ALTER TABLE filie_procesy_utwardzania_powloki CHANGE proces_utwardzania_id proces_utwardzania_id INT NOT NULL, CHANGE filia_id filia_id INT NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE filie_procesy_aplikacji CHANGE filia_id filia_id INT DEFAULT NULL, CHANGE proces_aplikacji_id proces_aplikacji_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE filie_procesy_utwardzania_powloki CHANGE filia_id filia_id INT DEFAULT NULL, CHANGE proces_utwardzania_id proces_utwardzania_id INT DEFAULT NULL");
    }
}
