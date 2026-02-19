<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'equipement_id',
        'user_id',
        'intervention_id',
        'type',
        'quantity',
        'description',
    ];

    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }
}
