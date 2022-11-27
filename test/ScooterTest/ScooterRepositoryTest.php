<?php

declare(strict_types=1);

namespace ScooterTest;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Scooter\Entities\Scooter;
use Scooter\Entities\ScooterRepository;

class ScooterRepositoryTest extends TestCase
{
    public function testUpdateScooterStatusFromRequest(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $entityManager->expects($this->once())->method('flush');

        $scooter = $this->createMock(Scooter::class);
        $scooter->expects($this->once())->method('setStatus')->with(1);

        $entityRepository = $this->createMock(EntityRepository::class);

        $entityManager->method('getRepository')->with(Scooter::class)->willReturn($entityRepository);
        $entityManager->expects($this->once())->method('flush');

        $entityRepository->method('find')->with(123)->willReturn($scooter);

        $request = (new ServerRequest(parsedBody: ['scooterId' => 123, 'status' => 1]))
            ->withAttribute('id', 123);

        $subject = new ScooterRepository($entityManager);

        $subject->updateStatusFromRequest($request);
    }
}
