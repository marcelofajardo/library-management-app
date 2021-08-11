<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLending extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at', 'deadline', 'return_date'];

    protected $with = ['book_copy', 'book_copy.book', 'user'];

    const PER_PAGE = 15;
    // in weeks
    const LENDING_TIME = 3;
    // in euros
    const DAILY_LATENESS_FINE = 5;

    protected $guarded = [];

    public function book_copy() 
    {
        return $this->belongsTo(BookCopy::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedDeadlineAttribute() 
    {
        return $this->deadline->format('d. m. Y.');
    }

    public function getFormattedReturnDateAttribute() 
    {
        return $this->return_date->format('d. m. Y.');
    }
}
