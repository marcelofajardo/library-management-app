<?php

namespace App\Models;

use Database\Seeders\BookStatusSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    use HasFactory;

    const QR_BASE_URL = 'http://127.0.0.1:8000/book-copies/';

    // statuses

    // const AVAILABLE = 0;
    // const UNAVAILABLE = 1;
    // const READING_ROOM_COPY = 2;

    // protected $with = ['book'];

    protected $guarded = [];

    protected $dates = ['publication_date', 'date_of_purchase', 'created_at', 'updated_at'];

    public function condition() {
        return $this->belongsTo(BookCondition::class);
    }

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function book_status() {
        return $this->belongsTo(BookStatus::class);
    }

    public function getFormattedPublicationDateAttribute() {
        return $this->publication_date->format('d. m. Y.');
    }

    public function getFormattedPurchaseDateAttribute() {
        return $this->date_of_purchase->format('d. m. Y.');
    }

    public function getIsAvailableAttribute() {
        return $this->book_status_id == BookStatus::AVAILABLE;
    }
}
