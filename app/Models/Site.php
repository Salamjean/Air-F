<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'location',
    ];

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }

    public function equipements()
    {
        return $this->belongsToMany(Equipement::class, 'equipement_site')
            ->withPivot('quantity', 'alert_threshold')
            ->withTimestamps();
    }
}
