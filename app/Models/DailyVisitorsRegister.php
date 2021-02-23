<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyVisitorsRegister extends Model
{
    use HasFactory;
    protected $fillable = [

            'user_id',
            'project_id',
            'company_name',
            'driver_contact',
            'visit_reason',
            'car_attachment',
            'id_attachment'
    ];
}
