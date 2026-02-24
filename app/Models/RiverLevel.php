<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiverLevel extends Model
{
    public $timestamps = false;

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function river()
    {
        return $this->belongsTo(River::class);
    }
}
