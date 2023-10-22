<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookShelf extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'book_id',
        'shelf_id',
        'row'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }
}
