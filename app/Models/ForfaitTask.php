<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForfaitTask extends Model
{
    protected $fillable = ['forfait_id', 'description'];

    public function forfait()
    {
        return $this->belongsTo(Forfait::class);
    }

    public function interventions()
    {
        return $this->belongsToMany(Intervention::class, 'intervention_forfait_task');
    }
}
