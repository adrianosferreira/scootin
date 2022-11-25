<?php

declare(strict_types=1);

namespace Scooter\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Attributes as OA;
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

    #[OA\Get(path: '/api/scooter/nearby')]
    #[OA\Response(response: '200', description: 'List scooters nearby you')]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parameters = $request->getQueryParams();
        $scooters   = $this->scooterRepository->getNearbyScooters(
            (float) $parameters['latitude'],
            (float) $parameters['longitude']
        );

        return new JsonResponse(['result' => $scooters]);
    }
}
