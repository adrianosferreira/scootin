<?php

declare(strict_types=1);

namespace ScooterTest;

use Exception;
use Laminas\Diactoros\ServerRequest;
use Monolog\Test\TestCase;
use Scooter\Entities\ScooterHistoryRepository;
use Scooter\Entities\ScooterRepository;
use Scooter\Handler\ScooterHistoryCreateHandler;

class ScooterHistoryCreateHandlerTest extends TestCase
{
    public function testUpdateScooterAndCreateHistoryEntry(): void
    {
        $scooterHistoryRepository = $this->createMock(ScooterHistoryRepository::class);
        $scooterRepository        = $this->createMock(ScooterRepository::class);

        $request = new ServerRequest(
            parsedBody: [
                'latitude'  => 10.12,
                'longitude' => 11.12,
                'userId'    => 123,
                'status'    => 1,
                'scooterId' => 123,
            ]
        );

        $scooterRepository->expects($this->once())->method('updateStatusFromRequest')->with($request);
        $scooterHistoryRepository->expects($this->once())->method('saveFromRequest')->with($request);

        $subject  = new ScooterHistoryCreateHandler($scooterHistoryRepository, $scooterRepository);
        $response = $subject->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testReturnsErrorWhenScooterOrHistoryCouldNotBeUpdated(): void
    {
        $scooterHistoryRepository = $this->createMock(ScooterHistoryRepository::class);
        $scooterRepository        = $this->createMock(ScooterRepository::class);

        $request = new ServerRequest(
            parsedBody: [
                'latitude'  => 10.12,
                'longitude' => 11.12,
                'userId'    => 123,
                'status'    => 1,
                'scooterId' => 123,
            ]
        );

        $scooterHistoryRepository->expects($this->once())->method('saveFromRequest')->with($request)
            ->willReturnCallback(fn () => throw new Exception());

        $subject  = new ScooterHistoryCreateHandler($scooterHistoryRepository, $scooterRepository);
        $response = $subject->handle($request);

        $this->assertEquals(500, $response->getStatusCode());
    }
}
