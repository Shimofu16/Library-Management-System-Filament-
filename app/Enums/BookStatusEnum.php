<?php
namespace App\Enums;

use Illuminate\Support\Str;

enum BookStatusEnum: string
{
    case AVAILABLE = 'Available';

    case NOTAVAILABLE = 'Not Available';

    case OUTOFSTOCK = 'Out of Stock';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[Str::lower($case->value)] = $case->value;
        }

        return $array;
    }
}
