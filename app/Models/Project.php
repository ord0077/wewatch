<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = [
        'user:id,name,email,role_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
