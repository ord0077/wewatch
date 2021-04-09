<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectDetail;


class DailyHseReport extends Model
{
    use HasFactory;
     protected $guarded = [];


     protected $with = [

//   'project:id,project_name',
    //  'projectdetail:id,daily_hse_report_id,weather,wind_strength,weather_wind_remarks,design_build_time,daily_operation_man_hour,design_time_hour_remarks,contractors,staff_numbers,shift_pattern,daily_man_hours,type_contractors,total_man_days,total_man_hours,total_lost_work_hours'  
     ];

  

     public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function projectdetail()
    {
         return $this->hasMany(ProjectDetail::class);
    }

    public function bulidactivity()
    {
        return $this->hasMany(BulidActivity::class);
    }

    public function projecthealthcompliance()
    {
        return $this->hasMany(ProjectHealthCompliance::class);
    }

    public function hazardidentify()
    {
        return $this->hasMany(HazardIdentify::class);
    }

    public function nearmissreporting()
    {
        return $this->hasMany(NearMissReporting::class);
    }

    public function covidcompliance()
    {
        return $this->hasMany(CovidCompliance::class);
    }

   
   
   

   
}
