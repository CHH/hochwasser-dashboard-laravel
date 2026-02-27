<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class River extends Model
{
    public $fillable = [
        'name',
        'pegel_id',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];

    public function levels()
    {
        return $this->hasMany(RiverLevel::class);
    }
}
