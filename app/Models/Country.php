<?php

namespace App\Models;

use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes, HasStatus;

    protected $fillable = [
        'name',
        'short_code',
        'phone_code',
        'status',
    ];

    /**
     * Relationship: One Country has many States.
     */
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    /**
     * Relationship: One Country has many Cities through States.
     */
    public function cities(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(City::class, State::class);
    }

    /**
     * Boot function to handle cascading soft-deletes and restorations.
     */
    protected static function booted()
    {
        static::deleting(function (Country $country) {
            if ($country->isForceDeleting()) {
                $country->states()->withTrashed()->get()->each->forceDelete();
            } else {
                $country->states()->get()->each->delete();
            }
        });

        static::restoring(function (Country $country) {
            $country->states()->onlyTrashed()->get()->each->restore();
        });
    }
}
