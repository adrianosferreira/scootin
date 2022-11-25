<?php

namespace Scooter\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Location\Coordinate;
use Location\Distance\DistanceInterface;
use Location\Distance\Vincenty;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Scooter\Entities\ScooterRepository;

class ScooterNearbyHandler implements RequestHandlerInterface
{

    public function __construct(
        private ScooterRepository $scooterRepository,
    ){
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parameters = $request->getQueryParams();

        $this->scooterRepository->getNearbyScooters($parameters['latitude'], $parameters['longitude']);

        $userLocation = new Coordinate($parameters['latitude'], $parameters['longitude']);

        return new JsonResponse(['test' => 1]);
    }
}