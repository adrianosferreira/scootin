<?php

declare(strict_types=1);

namespace ScooterTest;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Scooter\Entities\ScooterHistory;
use Scooter\Entities\ScooterHistoryRepository;

class ScooterHistoryRepositoryTest extends TestCase
{
    public function testPersistsNewHistoryInDatabase(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $serverRequest = new ServerRequest(
            parsedBody: [
                'latitude'  => 10.12,
                'longitude' => 11.12,
                'userId'    => 123,
                'status'    => 1,
            ]
        );

        $entityManager->expects($this->once())->method('persist')
            ->with(ScooterHistory::createFromRequest($serverRequest));

        $entityManager->expects($this->once())->method('flush');

        $subject = new ScooterHistoryRepository(new NullLogger(), $entityManager);
        $subject->saveFromRequest($serverRequest);
    }
}
