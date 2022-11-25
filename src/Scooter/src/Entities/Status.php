<?php

declare(strict_types=1);

namespace Scooter\Entities;

enum Status: int
{
    case FREE     = 0;
    case OCCUPIED = 1;
}
