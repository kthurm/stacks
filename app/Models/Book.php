<?php

namespace App\Models;


use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'cover_image',
        'publisher',
        'published_year',
        'publication_date',
        'category',
        'isbn',
        'page_count',
        'summary',
        'rating',
        'stock',
        'isCheckedOut',
        'available',
        'isFeatured',
    ];
    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)->withPivot('is_checked_out')->withTimestamps();
    }
}
