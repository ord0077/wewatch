<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccidentIncident extends Model
{
    use HasFactory;
    
    protected $fillable = [


        'user_id',
        'project_id',
        'location',
        'reported_date',
        'reported_time',
        'category_incident',
        'type_injury',
        'type_incident',
        'other',
        'fatality',
        'describe_incident',
        'immediate_action',
        'attachment',
    ];

    

}
