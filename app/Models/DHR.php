<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DHR extends Model
{
    use HasFactory;
    protected $guarded = [];


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
