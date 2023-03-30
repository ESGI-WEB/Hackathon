<?php

namespace App\Entity;

enum Status: string
{
    case PENDING = 'pending';
    case VALIDATED = 'validated';
    case REJECTED = 'rejected';
}
