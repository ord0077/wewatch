<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySecurityReport extends Model
{
    use HasFactory;
    protected $fillable = [
            
            'user_id',
            'daily_report_elements',
            'guard_organization',
            'no_staff',
            'no_incidents_daily',
            'no_visitors',
            'inspections',
            'observations',
            'travel_security_updates',
            'red_flag',
            'attachments'

                         ];
}
