<?php

namespace Scooter\Entities;

enum Status: int
{
    case FREE = 0;
    case OCCUPIED = 1;
}