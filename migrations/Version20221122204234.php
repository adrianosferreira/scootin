<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221122204234 extends AbstractMigration
{

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                INSERT INTO scooter (
                    id
                ) VALUES (1),(2),(3),(4),(5),(6)
            SQL
        );

        $this->addSql(
            <<<SQL
                INSERT INTO user (id, email) 
                VALUES 
                    (1, 'test1@gmail.com'),
                    (2, 'test2@gmail.com'),
                    (3, 'test3@gmail.com')
            SQL
        );

        $this->addSql(
            <<<SQL
                INSERT INTO scooter_history (
                    scooter_id,
                    latitude,
                    longitude,
                    status,
                    user_id                         
                ) VALUES 
                    (1, 10.111, 21.2122, 1, 1),
                    (2, 11.111, 22.2122, 1, 2),
                    (3, 12.111, 23.2122, 1, 3),
                    (4, 13.111, 24.2122, 1, 1),
                    (5, 14.111, 25.2122, 1, 2),
                    (6, 15.111, 26.2122, 1, 3)
            SQL
        );

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM scooter WHERE id IN (1, 2, 3, 4, 5, 6)');
    }
}
