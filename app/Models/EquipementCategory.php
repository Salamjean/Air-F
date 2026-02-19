<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipementCategory extends Model
{
    protected $fillable = [
        'name',
        'added_by',
    ];

    /**
     * Get the user who added this category.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    /**
     * Get the equipments for this category.
     */
    public function equipements(): HasMany
    {
        return $this->hasMany(Equipement::class, 'category_id');
    }
}
