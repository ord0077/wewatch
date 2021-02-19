<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    public $fillable =[ 

        'project_id',
        'observation_description',
        'action',
        'attachments'
    ];

}
