<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    const AVAILABLE = 1;
    const UNAVAILABLE = 2;
    const READING_ROOM_COPY = 3;
}
