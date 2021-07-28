<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ['publication_date', 'date_of_purchase', 'created_at', 'updated_at'];

    public function condition() {
        return $this->belongsTo(BookCondition::class);
    }

    public function getFormattedPublicationDateAttribute() {
        return $this->publication_date->format('d. m. Y.');
    }

    public function getFormattedPurchaseDateAttribute() {
        return $this->date_of_purchase->format('d. m. Y.');
    }
}
