<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    public $fillable =[ 

        'user_id',
        'project_id',
        'observation_description',
        'action',
        'attachments'
    ];

    // protected $guarded = [];

    protected $with = [
        'project:id,project_name'

    ];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    protected $casts = [
        'created_at' => 'datetime:d-M-y',
        'updated_at' => 'datetime:d-M-y'
    ];

    public function getImageAttribute($value)
    {
        return $this->attributes['image'] =  "data:image/jpeg;base64," . $value;
    }

}
