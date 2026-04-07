<?php

namespace App\Models;

use App\Traits\HasStatus;
use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy(ActiveScope::class)]
class State extends Model
{
    use HasFactory, SoftDeletes, HasStatus;

    protected $fillable = [
        'country_id',
        'name',
        'state_code',
        'status',
    ];

    /**
     * Relationship: One State belongs to one Country.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Relationship: One State has many Cities.
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * Boot function for cascading soft-deletes and restorations.
     */
    protected static function booted()
    {
        static::deleting(function (State $state) {
            if ($state->isForceDeleting()) {
                $state->cities()->withTrashed()->get()->each->forceDelete();
            } else {
                $state->cities()->get()->each->delete();
            }
        });

        static::restoring(function (State $state) {
            $state->cities()->onlyTrashed()->get()->each->restore();
        });
    }
}
