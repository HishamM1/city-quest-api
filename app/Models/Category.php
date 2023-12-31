<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public const CATEGORIES = [
        'Travel',
        'Food',
        'Religion',
        'Culture',
        'History',
        'Nature',
        'People',
        'Architecture',
        'Lifestyle',
        'Sports',
        'Music',
        'Art',
        'Fashion',
        'Entertainment',
        'Technology',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class, 'category_id');
    }
}
