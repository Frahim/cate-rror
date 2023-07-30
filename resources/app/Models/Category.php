<?php

namespace App\Models;

use App\Models\Brands;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $fillable =[
        'name',
        'slug',
        'description',       
        'cat_image', 
        'parent_id',      
        'meta_title',
        'meta_keyword',
        'meta_description',
      
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function brands()
    {
        return $this->hasMany(Brands::class, 'category_id', 'id');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relationship: a category belongs to a parent category
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
