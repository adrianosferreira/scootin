<?php

declare(strict_types=1);

namespace Scooter\Entities;

use Doctrine\ORM\Mapping as ORM;
use Psr\Http\Message\ServerRequestInterface;

use function filter_var;

use const FILTER_SANITIZE_FULL_SPECIAL_CHARS;
use const FILTER_SANITIZE_NUMBER_INT;

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
            ? filter_var($requestParameters['latitude'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            : throw new InvalidScooterHistoryRequest('The latitude field is missing');

        $longitude = isset($requestParameters['longitude'])
            ? filter_var($requestParameters['longitude'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            : throw new InvalidScooterHistoryRequest('The longitude field is missing');

        $userId = isset($requestParameters['userId'])
            ? filter_var($requestParameters['userId'], FILTER_SANITIZE_NUMBER_INT)
            : throw new InvalidScooterHistoryRequest('The userId field is missing');

        $status = isset($requestParameters['status'])
            ? filter_var(Status::tryFrom($requestParameters['status'])->value, FILTER_SANITIZE_NUMBER_INT)
            : throw new InvalidScooterHistoryRequest('The status field is missing');

        if ($status === null) {
            throw new InvalidScooterHistoryRequest('The status field is invalid');
        }

        $scooterId = isset($requestParameters['scooterId'])
            ? filter_var($requestParameters['scooterId'], FILTER_SANITIZE_NUMBER_INT)
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
