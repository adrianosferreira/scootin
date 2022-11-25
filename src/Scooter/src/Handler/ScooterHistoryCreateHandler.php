<?php

declare(strict_types=1);

namespace Scooter\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Scooter\Entities\ScooterHistoryRepository;
use Throwable;

class ScooterHistoryCreateHandler implements RequestHandlerInterface
{
    public function __construct(
        private ScooterHistoryRepository $scooterHistoryRepository,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->scooterHistoryRepository->saveFromRequest($request);
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
