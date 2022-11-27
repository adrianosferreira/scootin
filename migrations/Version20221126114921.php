<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Creates basic authentication table and populates it
 */
final class Version20221126114921 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
                CREATE TABLE apikey
                (
                    id int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                    username VARCHAR(50) NOT NULL,
                    apikey VARCHAR(100) NOT NULL,
                    created DATETIME default CURRENT_TIMESTAMP,  
                    updated DATETIME default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  
                )
            SQL
        );

        //oZq!63ydPHB0
        $this->addSql(
            <<<SQL
                INSERT INTO apikey (
                    username, apikey
                ) VALUES ('mobile', '$2y$10\$qLXfumGQ1rUV5MbmKw3GSOHCDsfUEYay6ulQAOV4pcIQX4orfmhNe')
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE apikey');
    }
}
