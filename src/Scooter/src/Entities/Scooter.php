<?php

declare(strict_types=1);

namespace Scooter\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'scooter')]
class Scooter
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    public int $id;

    #[ORM\Column(type: 'integer')]
    public int $status;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
