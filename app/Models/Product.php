<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // fields we can use for sorting
    private static $sortable = ['name', 'price'];

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public static function getSortableFields() {
        return self::$sortable;
    }
}
