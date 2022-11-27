<?php

declare(strict_types=1);

namespace Scooter\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Scooter\Entities\ScooterRepository;
use Throwable;

class ScooterNearbyHandler implements RequestHandlerInterface
{
    public function __construct(
        private ScooterRepository $scooterRepository,
    ) {
    }

    #[OA\Get(
        path: '/api/scooters/nearby',
        description: 'Find scooters that are nearby a particular geographical position (up to 1 km).',
        parameters: [
            new OA\Parameter(name: 'latitude', required: true),
            new OA\Parameter(name: 'longitude', required: true),
        ],
        responses: [
            new OA\Response(response: '200', description: 'List of scooters nearby.', content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'result', type: 'array', items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'scooter_id', type: 'int'),
                            new OA\Property(property: 'distance', description: 'Distance in KM', type: 'float'),
                            new OA\Property(property: 'latitude', type: 'float'),
                            new OA\Property(property: 'longitude', type: 'float'),
                        ]
                    )),
                ]
            )),
            new OA\Response(response: '400', description: 'Request missing parameters'),
        ],
    )]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $scooters = $this->scooterRepository->getNearbyScootersFromRequest($request);
        } catch (Throwable $exception) {
            return new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                ],
                400
            );
        }

        return new JsonResponse(['result' => $scooters]);
    }
}
