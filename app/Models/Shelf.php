<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shelf extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = [
        'number',
        'rows',
        'capacity',
    ];

    protected $casts = [
        'rows' => 'array',
    ];



    public function bookShelves()
    {
        return $this->hasMany(BookShelf::class);
    }
}
