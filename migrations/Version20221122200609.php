<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221122200609 extends AbstractMigration
{

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                CREATE TABLE scooter
                (
                    id int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                    status TINYINT(3) DEFAULT 0 NOT NULL,
                    created DATETIME default CURRENT_TIMESTAMP,  
                    updated DATETIME default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  
                )
            SQL
        );

        $this->addSql(
            <<<SQL
                CREATE TABLE scooter_history
                (
                    id int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                    scooter_id int(11),
                    latitude DECIMAL(8,6) SIGNED NOT NULL,
                    longitude DECIMAL(9,6) SIGNED NOT NULL,
                    status TINYINT(3) NOT NULL,
                    user_id int (11) NOT NULL,
                    created DATETIME default CURRENT_TIMESTAMP,  
                    updated DATETIME default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  
                )
            SQL
        );

        $this->addSql(
            <<<SQL
                CREATE TABLE user
                (
                    id int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                    email VARCHAR(100) NOT NULL,
                    created DATETIME default CURRENT_TIMESTAMP,  
                    updated DATETIME default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  
                )
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE scooter');
        $this->addSql('DROP TABLE scooter_history');
        $this->addSql('DROP TABLE user');
    }
}
