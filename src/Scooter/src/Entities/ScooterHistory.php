<?php

namespace Scooter\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'scooter_history')]
class ScooterHistory
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;
    private int $scooter_id;

    #[ORM\Column(type: 'decimal')]
    private float $latitude;

    #[ORM\Column(type: 'decimal')]
    private float $longitude;

    #[ORM\Column(type: 'integer')]
    private int $status;

    #[ORM\Column(type: 'integer')]
    private int $user_id;

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
}