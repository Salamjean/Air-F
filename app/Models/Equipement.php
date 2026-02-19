<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipement extends Model
{
    protected $fillable = [
        'name',
        'longueur',
        'type',
        'numero_bien',
        'category_id',
        'description',
        'image',
        'added_by',
        'unit',
        'stock_quantity',
        'stock_min_alert',
    ];

    /**
     * The sites where this equipment is stocked.
     */
    public function sites()
    {
        return $this->belongsToMany(Site::class, 'equipement_site')
            ->withPivot('quantity', 'alert_threshold')
            ->withTimestamps();
    }

    /**
     * Get the category that this equipment belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipementCategory::class, 'category_id');
    }

    /**
     * Get the user who added this equipment.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    /**
     * The interventions where this equipment was used.
     */
    public function interventions()
    {
        return $this->belongsToMany(Intervention::class, 'intervention_equipement')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Get the stock movements for this equipment.
     */
    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }
}

