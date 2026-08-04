<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorialSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutorial_category_id',
        'name',
        'slug',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(TutorialCategory::class, 'tutorial_category_id');
    }

    public function tutorials()
    {
        return $this->hasMany(Tutorial::class, 'tutorial_sub_category_id');
    }
}
