<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forfait extends Model
{
    protected $fillable = ['name', 'label', 'price'];

    public function tasks()
    {
        return $this->hasMany(ForfaitTask::class);
    }
}
