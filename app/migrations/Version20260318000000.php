<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260318000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Allow NULL on invoice_line.description';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE invoice_line CHANGE description description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE invoice_line CHANGE description description LONGTEXT NOT NULL');
    }
}
