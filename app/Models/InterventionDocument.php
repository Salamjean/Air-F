<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterventionDocument extends Model
{
    protected $fillable = [
        'intervention_id',
        'file_path',
        'original_name',
        'file_type',
    ];

    public function intervention(): BelongsTo
    {
        return $this->belongsTo(Intervention::class);
    }
}
