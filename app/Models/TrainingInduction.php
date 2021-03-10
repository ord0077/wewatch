<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingInduction extends Model
{
    use HasFactory;

    protected $table = 'training_inductions';

    protected $guarded=[];

    
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

    public function getAttachmentsAttribute($value)
    {
        return $this->attributes['attachments'] =  "data:image/jpeg;base64," . $value;
    }

}
