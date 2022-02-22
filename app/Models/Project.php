<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = [
        'user:id,name,email,role_id',
        'zones:project_id,zone_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
    public function dhr()
    {
        return $this->hasMany(DHR::class);
    }
    public function AI()
    {
        return $this->hasMany(AccidentIncident::class);
    }
    public function allocation()
    {
        return $this->hasMany(Allocation::class);
    }
    public function covid()
    {
        return $this->hasMany(Covid::class);
    }
    public function dailysecurityreport()
    {
        return $this->hasMany(DailySecurityReport::class);
    }
    public function dvr()
    {
        return $this->hasMany(DailyVisitorsRegister::class);
    }
    public function DSR()
    {
        return $this->hasMany(DSR::class);
    }
    public function hsereport()
    {
        return $this->hasMany(HseReport::class);
    }
    public function observation()
    {
        return $this->hasMany(Observation::class);
    }
    public function recipient()
    {
        return $this->hasMany(Recipient::class);
    }
    public function traininginduction()
    {
        return $this->hasMany(TrainingInduction::class);
    }
    protected $casts = [
        // 'start_date' => 'datetime:d-M-y',
        // 'end_date' => 'datetime:d-M-y',
    ];
}
