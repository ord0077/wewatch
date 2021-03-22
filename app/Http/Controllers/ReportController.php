<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Covid;
use App\Models\AccidentIncident;
use App\Models\TrainingInduction;
use App\Models\DailyVisitorsRegister;
use App\Models\DailySecurityReport;
use App\Models\Observation;
use App\Models\User;
use App\Models\Project;

class ReportController extends Controller
{
    public function GetCovidCount($id = null)
    {
        if(isset($id)){
            return Covid::where('project_id', $id)->count();
        }
        else{
            return Covid::all()->count();
        }
    }
    public function GetAccidentIncidentCount($id = null)
    {
        if(isset($id)){
            return AccidentIncident::where('project_id', $id)->count();
        }
        else{
            return AccidentIncident::all()->count();
        }
    }

    public function GetTrainingInductionCount($id = null)
    {
        if(isset($id)){
            return TrainingInduction::where('project_id', $id)->count();
        }
        else{
            return TrainingInduction::all()->count();
        }
    }

    public function GetObservationCount($id = null)
    {
        if(isset($id)){
            return Observation::where('project_id', $id)->count();
        }
        else{
            return Observation::all()->count();
        }
    }

    public function GetDailyHSEReportCount($id = null)
    {
        return 88;
        if(isset($id)){
            return Covid::where('project_id', $id)->count();
        }
        else{
            return Covid::all()->count();
        }
    }

    public function GetDailySecurityReportCount($id = null)
    {
        if(isset($id)){
            return DailySecurityReport::where('project_id', $id)->count();
        }
        else{
            return DailySecurityReport::all()->count();
        }
    }

    public function GetSiteVisiterRecordCount($id = null)
    {
        if(isset($id)){
            return DailyVisitorsRegister::where('project_id', $id)->count();
        }
        else{
            return DailyVisitorsRegister::all()->count();
        }
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
    public function count_by_project($id)
    {
        return [
            'GetCovidCount' => $this->GetCovidCount($id),
            'GetAccidentIncidentCount' => $this->GetAccidentIncidentCount($id),
            'GetObservationCount' => $this->GetObservationCount($id),
            'GetTrainingInductionCount' => $this->GetTrainingInductionCount($id),
            'GetDailyHSEReportCount' => $this->GetDailyHSEReportCount($id),
            'GetDailySecurityReportCount' => $this->GetDailySecurityReportCount($id),
            'GetSiteVisiterRecordCount' => $this->GetSiteVisiterRecordCount($id)            
        ];
    }
}
