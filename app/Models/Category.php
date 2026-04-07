<?php

namespace App\Models;

use App\Traits\HasStatus;
use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[ScopedBy(ActiveScope::class)]
class Category extends Model
{
    use HasFactory, SoftDeletes, HasStatus;

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    /**
     * Boot function for automatic slug generation.
     */
    protected static function booted()
    {
        static::saving(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
