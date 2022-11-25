<?php

declare(strict_types=1);

namespace Scooter\Entities;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;

use function sprintf;

class ScooterHistoryRepository
{
    public function __construct(
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function createFromRequest(ServerRequestInterface $request): void
    {
        try {
            $scooterHistory = ScooterHistory::createFromRequest($request);
        } catch (Throwable $exception) {
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
