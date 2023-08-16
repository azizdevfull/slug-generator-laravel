<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $slug = $product->generateUniqueSlug($product->name);
            $product->slug = $slug;
        });
    }

    private function generateUniqueSlug($name, $count = 0)
    {
        $slug = Str::slug($name);

        if ($count > 0) {
            $slug .= "-ID$count";
        }

        if (Product::where('slug', $slug)->exists()) {
            return $this->generateUniqueSlug($name, $count + 1);
        }

        return $slug;
    }

}
