<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $guarded = [];

    const PER_PAGE = 10;

    public function author() {
        return $this->belongsTo(Author::class);
    }

    public function publisher() {
        return $this->belongsTo(Publisher::class);
    }

    public function requiredCopies() {
        return $this->available_quantity - BookCopy::query()->where('book_id', '=', $this->id)->count();
    }
}
