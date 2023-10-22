<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum BookGenreEnum: string
{
    case ACTION = 'Action';
    case ADVENTURE = 'Adventure';
    case BIOGRAPHY = 'Biography';
    case BUSINESS = 'Business';
    case CHILDREN = 'Children';
    case COMIC = 'Comic';
    case CRIME = 'Crime';
    case DRAMA = 'Drama';
    case FANTASY = 'Fantasy';
    case FICTION = 'Fiction';
    case HISTORY = 'History';
    case HORROR = 'Horror';
    case HUMOR = 'Humor';
    case MYSTERY = 'Mystery';
    case NONFICTION = 'Nonfiction';
    case POETRY = 'Poetry';
    case ROMANCE = 'Romance';
    case SCIENCEFICTION = 'Science Fiction';
    case SELFHELP = 'Self Help';
    case SPORTS = 'Sports';
    case THRILLER = 'Thriller';
    case TRAVEL = 'Travel';
    case WESTERN = 'Western';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[Str::lower($case->value)] = $case->value;
        }

        return $array;
    }
}
