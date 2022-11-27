<?php

declare(strict_types=1);

namespace Scooter\Entities;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ServerRequestInterface;

class ScooterRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws InvalidScooterRequest
     */
    public function updateStatusFromRequest(ServerRequestInterface $request): void
    {
        $requestParameters = $request->getParsedBody();

        $scooter = $this->entityManager->getRepository(Scooter::class)->find($request->getAttribute('id'));

        if (!$scooter) {
            throw new InvalidScooterRequest('The scooter cannot be find');
        }

        if (!isset($requestParameters['status'])) {
            throw new InvalidScooterRequest('The status field is missing');
        }

        $scooter->setStatus($requestParameters['status']);

        $this->entityManager->flush();
    }

    public function getNearbyScootersFromRequest(ServerRequestInterface $request): mixed
    {
        $parameters = $request->getQueryParams();

        if (! isset($parameters['latitude'])) {
            throw new InvalidScooterRequest('The latitude field is missing');
        }

        if (! isset($parameters['longitude'])) {
            throw new InvalidScooterRequest('The longitude field is missing');
        }

        $latitude  = (float) $parameters['latitude'];
        $longitude = (float) $parameters['longitude'];

        $circularDistanceKilometers = 1;

        $query = $this->entityManager->createQuery(
            <<<SQL
                SELECT 
                    ANY_VALUE(scooter_history.scooter_id) as scooter_id, 
                    (6371 * acos( cos( radians($latitude) ) * cos( radians( ANY_VALUE(scooter_history.latitude) ) ) * 
                    cos( radians( ANY_VALUE(scooter_history.longitude) ) 
                             - radians($longitude) ) + sin( radians($latitude) ) * 
                    sin( radians( ANY_VALUE(scooter_history.latitude) ) ) ) )
                    AS distance,
                    ANY_VALUE(scooter_history.longitude) longitude,
                    ANY_VALUE(scooter_history.latitude) latitude
                FROM
                    Scooter\Entities\Scooter as scooter
                LEFT JOIN
                    Scooter\Entities\ScooterHistory AS scooter_history
                WITH scooter.id = scooter_history.scooter_id
                WHERE 
                    scooter.status = 0
                GROUP BY scooter_history.scooter_id
                HAVING
                    distance <= $circularDistanceKilometers
                ORDER BY 
                    distance ASC
            SQL
        );

        return $query->getResult();
    }
}
