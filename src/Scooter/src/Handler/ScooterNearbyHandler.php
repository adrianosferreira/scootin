<?php

declare(strict_types=1);

namespace Scooter\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Scooter\Entities\ScooterRepository;

class ScooterNearbyHandler implements RequestHandlerInterface
{
    public function __construct(
        private ScooterRepository $scooterRepository,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parameters = $request->getQueryParams();
        $scooters   = $this->scooterRepository->getNearbyScooters($parameters['latitude'], $parameters['longitude']);

        return new JsonResponse(['result' => $scooters]);
    }
}
