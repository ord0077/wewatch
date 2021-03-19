<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Covid;
use App\Models\AccidentIncident;
use App\Models\TrainingInduction;
use App\Models\DailyVisitorsRegister;
use App\Models\Observation;
use App\Models\User;
use App\Models\Project;

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
        return DailyVisitorsRegister::all()->count();
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

    public function ProjectAdminCount()
    {
        return User::where('role_id',2)->get()->count();
    }
    public function WewatchManagerCount()
    {
        return User::where('role_id',4)->get()->count();
    }
    public function UserCount()
    {
        return User::where('role_id',5)->get()->count();
    }
    public function SecurityGuardCount()
    {
        return User::where('role_id',7)->get()->count();
    }
    public function ProjectCount()
    {
        return Project::all()->count();
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
            'GetLostWorkHoursCount' => $this->GetLostWorkHoursCount(),
            'ProjectAdminCount' => $this->ProjectAdminCount(),
            'WewatchManagerCount' => $this->WewatchManagerCount(),
            'UserCount' => $this->UserCount(),
            'SecurityGuardCount' => $this->SecurityGuardCount(),
            'ProjectCount' => $this->ProjectCount()
            
        ];
    }
}
