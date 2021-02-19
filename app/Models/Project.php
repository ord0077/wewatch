<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = [
        'user:id,name,email,role_id',
        'zones:project_id,zone_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
    protected $casts = [
        // 'start_date' => 'datetime:d-M-y',
        // 'end_date' => 'datetime:d-M-y',
    ];
}
