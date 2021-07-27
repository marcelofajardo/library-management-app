<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function condition() {
        return $this->belongsTo(BookCondition::class);
    }
}
