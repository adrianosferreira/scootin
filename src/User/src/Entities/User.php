<?php

declare(strict_types=1);

namespace User\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    public int $id;

    #[ORM\Column(type: 'string')]
    public string $email;

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
