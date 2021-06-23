<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623134052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Permet d\'enregistrer des livres.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(128) NOT NULL, resume LONGTEXT NOT NULL, pages_count SMALLINT NOT NULL, published_at DATETIME DEFAULT NULL, isbn VARCHAR(32) DEFAULT NULL, in_sell TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_account (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(128) NOT NULL, email VARCHAR(128) NOT NULL, password VARCHAR(64) DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_253B48AE539B0606 (uid), UNIQUE INDEX UNIQ_253B48AEE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE user_account');
    }
}
