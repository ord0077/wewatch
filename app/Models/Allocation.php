<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = [
        'project:id,project_name'

    ];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    protected $casts = [
        'user_ids' => 'array',
        'manager_ids' => 'array',
        'created_at' => 'datetime:d-M-y',
        'updated_at' => 'datetime:d-M-y'
    ];
}
