<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = [
        'author_id',
        'cover',
        'title',
        'synopsis',
        'genre',
        'publisher_id',
        'publication_date',
        'isbn',
        'stock',
        'status',
    ];  

    protected $casts = [
        'genre' => 'array',
    ];


    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function bookShelf()
    {
        return $this->hasOne(bookShelf::class);
    }

    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class);
    }
}
