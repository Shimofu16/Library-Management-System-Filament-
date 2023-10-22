<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum RoleEnum: string
{

    case ADMIN = 'Admin';

    case STUDENT = 'Student';

    case LIBRARIAN = 'Librarian';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[Str::lower($case->value)] = $case->value;
        }

        return $array;
    }
}
