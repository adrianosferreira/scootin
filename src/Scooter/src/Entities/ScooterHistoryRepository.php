<?php

namespace Scooter\Entities;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class ScooterHistoryRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    ) {
    }

    public function saveFromRequest(ServerRequestInterface $request): void
    {
        try {
            $scooterHistory = ScooterHistory::createFromRequest($request);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());

            throw $exception;
        }

        $this->entityManager->persist($scooterHistory);
        $this->entityManager->flush();

        $this->logger->info(
            sprintf(
                'New history entry created for scooter #%d and user #%d',
                $scooterHistory->scooter_id,
                $scooterHistory->user_id
            )
        );
    }
}
