<?php
namespace App\Enums;

use Illuminate\Support\Str;

enum FulfillmentStatusEnum: string
{
    case PENDING = 'Pending';

    case FULFILLED = 'Fulfilled';

    case CANCELED = 'Canceled';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[Str::lower($case->value)] = $case->value;
        }

        return $array;
    }
}
