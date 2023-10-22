<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum BorrowerGradeLevelEnum: string
{
    case GRADE7 = 'Grade 7';

    case GRADE8 = 'Grade 8';

    case GRADE9 = 'Grade 9';

    case GRADE10 = 'Grade 10';

    case GRADE11 = 'Grade 11';

    case GRADE12 = 'Grade 12';

    case COLLEGE = 'College';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[Str::lower($case->value)] = $case->value;
        }

        return $array;
    }
}
