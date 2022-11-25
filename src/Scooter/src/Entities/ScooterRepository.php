<?php

namespace Scooter\Entities;

use Doctrine\ORM\EntityManagerInterface;

class ScooterRepository
{

    public function __construct(
        private EntityManagerInterface $entityManager
    ){

    }

    public function getNearbyScooters(float $latitude, float $longitude)
    {
        $query = $this->entityManager->createQuery(
            <<<SQL
                SELECT 
                    scooter_history.scooter_id, 
                    ( 
                        3959 * acos( cos( radians($latitude) ) * cos( radians( scooter_history.latitude ) ) * 
                        cos( radians( scooter_history.longitude ) - radians($longitude) ) + sin( radians($latitude) ) * 
                        sin( radians( scooter_history.latitude ) ) ) ) AS distance 
                FROM 
                    Scooter\Entities\ScooterHistory AS scooter_history
                HAVING 
                    distance <= 211
                ORDER BY 
                    distance
            SQL
        );

        var_dump($query->getArrayResult());
    }
}