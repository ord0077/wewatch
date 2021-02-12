<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = [
        'project:id,project_name,project_logo,location,start_date,end_date'
    ];

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
