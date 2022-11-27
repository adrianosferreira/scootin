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
                ) VALUES (1),(2),(3),(4),(5),(6),(7)
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
                    (1, 48.14519672955476, 11.479293307643067, 0, 0),
                    (2, 48.14517867021376, 11.479780486947936, 0, 0),
                    (3, 48.14514857129798, 11.480655605328902, 0, 0),
                    (4, 48.14512148225868, 11.48131419957437, 0, 0),
                    (5, 48.145097403100635, 11.481954750141881, 0, 0),
                    (6, 48.14506429423986, 11.482532147836542, 0, 0),
                    (7, 48.14500108635551, 11.483429820814955, 0, 0)
            SQL
        );

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM scooter WHERE id IN (1, 2, 3, 4, 5, 6, 7)');
        $this->addSql('DELETE FROM scooter_history WHERE id scooter_id (1, 2, 3, 4, 5, 6, 7)');
    }
}
