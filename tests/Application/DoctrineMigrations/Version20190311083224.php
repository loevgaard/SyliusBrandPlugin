<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190311083224 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add new code field to brand, copy slug to code, make code unique';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_680CAA08989D9B62 ON loevgaard_brand');
        $this->addSql('ALTER TABLE loevgaard_brand ADD code VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('UPDATE loevgaard_brand SET code = slug');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_680CAA0877153098 ON loevgaard_brand (code)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_680CAA0877153098 ON loevgaard_brand');
        $this->addSql('ALTER TABLE loevgaard_brand DROP code');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_680CAA08989D9B62 ON loevgaard_brand (slug)');
    }
}
