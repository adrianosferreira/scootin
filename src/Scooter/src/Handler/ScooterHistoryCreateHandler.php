<?php

declare(strict_types=1);

namespace Scooter\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Scooter\Entities\ScooterHistoryRepository;
use Scooter\Entities\ScooterRepository;
use Throwable;

class ScooterHistoryCreateHandler implements RequestHandlerInterface
{
    public function __construct(
        private ScooterHistoryRepository $scooterHistoryRepository,
        private ScooterRepository $scooterRepository,
    ) {
    }

    #[OA\Post(
        path: '/api/scooter/{id}/history',
        description: 'Insert new history events for a particular scooter.',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'latitude', type: 'float'),
                    new OA\Property(property: 'longitude', type: 'float'),
                    new OA\Property(property: 'userId', type: 'int'),
                    new OA\Property(property: 'status', type: 'int'),
                ]
            )
        ),
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The id of the scooter.',
                in: 'path',
                required: true
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 401, description: 'Not allowed'),
            new OA\Response(response: 500, description: 'Internal error'),
        ]
    )]
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->scooterHistoryRepository->saveFromRequest($request);
            $this->scooterRepository->updateStatusFromRequest($request);
        } catch (Throwable $exception) {
            return new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                ],
                500
            );
        }

        return new JsonResponse(
            [
                'created' => true,
            ],
            200
        );
    }
}
