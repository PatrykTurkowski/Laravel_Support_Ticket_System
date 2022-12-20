<?php

namespace App\Enums;

use Othyn\PhpEnumEnhancements\Traits\EnumEnhancements;

enum RoleEnum: string
{
    use EnumEnhancements;
    case ADMIN = 'admin';
    case AGENT = 'agent';
    case USER = 'user';
}