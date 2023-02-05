<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230205153849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ranking (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, riddle_id INT DEFAULT NULL, number_of_tries INT DEFAULT NULL, INDEX IDX_80B839D0A76ED395 (user_id), INDEX IDX_80B839D0D25EE088 (riddle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE riddle (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, entitled LONGTEXT DEFAULT NULL, INDEX IDX_6C00AA81F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ranking ADD CONSTRAINT FK_80B839D0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ranking ADD CONSTRAINT FK_80B839D0D25EE088 FOREIGN KEY (riddle_id) REFERENCES riddle (id)');
        $this->addSql('ALTER TABLE riddle ADD CONSTRAINT FK_6C00AA81F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ranking DROP FOREIGN KEY FK_80B839D0A76ED395');
        $this->addSql('ALTER TABLE ranking DROP FOREIGN KEY FK_80B839D0D25EE088');
        $this->addSql('ALTER TABLE riddle DROP FOREIGN KEY FK_6C00AA81F675F31B');
        $this->addSql('DROP TABLE ranking');
        $this->addSql('DROP TABLE riddle');
    }
}
