<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowedBook extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = [
        'book_id',
        'borrower_id',
        'borrowed_date',
        'due_date',
        'returned_date',
        'is_returned',
        'notes',
    ];
    protected $casts = [
        'is_returned' => 'boolean',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }
}
