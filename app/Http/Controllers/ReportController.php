<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Covid;
use App\Models\AccidentIncident;
use App\Models\TrainingInduction;
use App\Models\Observation;

class ReportController extends Controller
{
    public function GetCovidCount()
    {
        return Covid::all()->count();
    }
    public function GetAccidentIncidentCount()
    {
        return AccidentIncident::all()->count();
    }

    public function GetTrainingInductionCount()
    {
        return TrainingInduction::all()->count();
    }

    public function GetObservationCount()
    {
        return Observation::all()->count();
    }

    public function GetDailyHSEReportCount()
    {
        return 559;
        return Covid::all()->count();
    }

    public function GetDailySecurityReportCount()
    {
        return 23;
        return Covid::all()->count();
    }

    public function GetSiteVisiterRecordCount()
    {
        return 199;
        return Covid::all()->count();
    }

    public function GetDailyManHoursCount()
    {
        return 125;
        return Covid::all()->count();
    }

    public function GetLostWorkHoursCount()
    {
        return 523;
        return Covid::all()->count();
    }

    public function all()
    {
        return [
            'GetCovidCount' => $this->GetCovidCount(),
            'GetAccidentIncidentCount' => $this->GetAccidentIncidentCount(),
            'GetObservationCount' => $this->GetObservationCount(),
            'GetTrainingInductionCount' => $this->GetTrainingInductionCount(),
            'GetDailyHSEReportCount' => $this->GetDailyHSEReportCount(),
            'GetDailySecurityReportCount' => $this->GetDailySecurityReportCount(),
            'GetSiteVisiterRecordCount' => $this->GetSiteVisiterRecordCount(),
            'GetDailyManHoursCount' => $this->GetDailyManHoursCount(),
            'GetLostWorkHoursCount' => $this->GetLostWorkHoursCount()
            
        ];
    }
}
