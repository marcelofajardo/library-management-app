<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['author', 'publisher', 'book_copies'];

    const PER_PAGE = 10;

    public function author() {
        return $this->belongsTo(Author::class);
    }

    public function book_copies() {
        return $this->hasMany(BookCopy::class);
    }

    public function publisher() {
        return $this->belongsTo(Publisher::class);
    }

    public function requiredCopies() {
        return $this->quantity - BookCopy::query()->where('book_id', '=', $this->id)->count();
    }
}
