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

    
    protected $with = [
        'project:id,project_name'

    ];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    protected $casts = [
        // 'reported_date' => 'datetime:d-M-y',
        // 'reported_time' => 'datetime:h:i: A',
        // 'created_at' => 'datetime:d-M-y--- h:i: A',
        // 'updated_at' => 'datetime:d-M-y'
    ];

    public function getAttachmentAttribute($value)
    {
        return $this->attributes['attachment'] =  "data:image/jpeg;base64," . $value;
    }

}
