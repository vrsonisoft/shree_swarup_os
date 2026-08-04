<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TutorialCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function tutorials()
    {
        return $this->hasMany(Tutorial::class);
    }

    public function subCategories()
    {
        return $this->hasMany(TutorialSubCategory::class, 'tutorial_category_id');
    }
}

