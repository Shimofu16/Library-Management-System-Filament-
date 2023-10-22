<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrower extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = [
        'student_id',
        'name',
        'email',
        'birth_date',
        'phone_number',
        'address',
        'school',
        'grade_level',
    ];

    protected $casts = [
        'birth_date' => 'date'
    ];


    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }


}
