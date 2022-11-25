<?php

declare(strict_types=1);

namespace Scooter\Handler;

use Laminas\Diactoros\Response\JsonResponse;
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

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->scooterHistoryRepository->createFromRequest($request);
            $this->scooterRepository->updateFromRequest($request);
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
