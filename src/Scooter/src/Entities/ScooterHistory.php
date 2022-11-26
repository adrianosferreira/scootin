<?php

declare(strict_types=1);

namespace Scooter\Entities;

use Doctrine\ORM\Mapping as ORM;
use Psr\Http\Message\ServerRequestInterface;

#[ORM\Entity]
#[ORM\Table(name: 'scooter_history')]
class ScooterHistory
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    public readonly int $id;

    #[ORM\ManyToOne(targetEntity: Scooter::class)]
    #[ORM\Column(type: 'integer')]
    public readonly int $scooter_id;

    #[ORM\Column(type: 'decimal')]
    public readonly float $latitude;

    #[ORM\Column(type: 'decimal')]
    public readonly float $longitude;

    #[ORM\Column(type: 'integer')]
    public readonly int $status;

    #[ORM\Column(type: 'integer')]
    public readonly int $user_id;

    public function setScooterId(int $scooterId): void
    {
        $this->scooter_id = $scooterId;
    }

    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function setUserId(int $userId): void
    {
        $this->user_id = $userId;
    }

    public static function createFromRequest(ServerRequestInterface $request): self
    {
        $requestParameters = $request->getParsedBody();

        $latitude = isset($requestParameters['latitude'])
            ? (float) $requestParameters['latitude']
            : throw new InvalidScooterHistoryRequest('The latitude field is missing');

        $longitude = isset($requestParameters['longitude'])
            ? (float) $requestParameters['longitude']
            : throw new InvalidScooterHistoryRequest('The longitude field is missing');

        $userId = isset($requestParameters['userId'])
            ? (int) $requestParameters['userId']
            : throw new InvalidScooterHistoryRequest('The userId field is missing');

        $status = isset($requestParameters['status'])
            ? Status::tryFrom($requestParameters['status'])->value
            : throw new InvalidScooterHistoryRequest('The status field is missing');

        if ($status === null) {
            throw new InvalidScooterHistoryRequest('The status field is invalid');
        }

        $scooterId = isset($requestParameters['scooterId'])
            ? (int) $requestParameters['scooterId']
            : throw new InvalidScooterHistoryRequest('The scooterId field is missing');

        $scooterHistory = new ScooterHistory();
        $scooterHistory->setStatus($status);
        $scooterHistory->setUserId($userId);
        $scooterHistory->setLatitude($latitude);
        $scooterHistory->setLongitude($longitude);
        $scooterHistory->setScooterId($scooterId);

        return $scooterHistory;
    }
}
