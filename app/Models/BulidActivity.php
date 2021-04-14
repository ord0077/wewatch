<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulidActivity extends Model
{
    protected $guarded = [];
    use HasFactory;
    
    public function getOccurenceAttribute($value)
    {
        return $value == 1?"Yes":"No";
    }
}
