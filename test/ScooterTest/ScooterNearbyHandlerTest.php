<?php

declare(strict_types=1);

namespace ScooterTest;

use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Scooter\Entities\ScooterRepository;
use Scooter\Handler\ScooterNearbyHandler;

use function json_encode;

class ScooterNearbyHandlerTest extends TestCase
{
    public function testReturnsScootersNearby(): void
    {
        $scooterRepository = $this->createMock(ScooterRepository::class);

        $latitude  = 10.11;
        $longitude = 11.11;

        $scooterRepository->method('getNearbyScooters')
            ->with($latitude, $longitude)
            ->willReturn(
                [
                    ['scooter_id' => 3],
                    ['scooter_id' => 1],
                    ['scooter_id' => 2],
                ],
            );

        $subject = new ScooterNearbyHandler($scooterRepository);

        $response = $subject->handle(
            new ServerRequest(queryParams: ['latitude' => $latitude, 'longitude' => $longitude])
        );

        $this->assertEquals(
            json_encode([
                'result' => [
                    ['scooter_id' => 3],
                    ['scooter_id' => 1],
                    ['scooter_id' => 2],
                ],
            ]),
            $response->getBody()->getContents(),
        );
    }
}
