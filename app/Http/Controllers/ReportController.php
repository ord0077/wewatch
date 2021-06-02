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
use App\Models\HseReport;

class ReportController extends Controller
{    
  
    public function all()
    {
        return [

            'ProjectAdminCount' => User::where('role_id',2)->count(),
            'WewatchManagerCount' => User::where('role_id',4)->count(),
            'UserCount' => User::where('role_id',5)->count(),
            'SecurityGuardCount' => User::where('role_id',7)->count(),
            'ProjectCount' => Project::count()
            
        ];
    }

    public function count_by_project($id)
    {
        return [

            'GetCovidCount' => Covid::where('project_id', $id)->count(),
            'GetAccidentIncidentCount' => AccidentIncident::where('project_id', $id)->count(),
            'GetObservationCount' => Observation::where('project_id', $id)->count(),
            'GetTrainingInductionCount' => TrainingInduction::where('project_id', $id)->count(),
            'GetDailyHSEReportCount' => HseReport::where('project_id', $id)->count(),
            'GetDailySecurityReportCount' => DailySecurityReport::where('project_id', $id)->count(),
            'GetSiteVisiterRecordCount' => DailyVisitorsRegister::where('project_id', $id)->count(),

        ];
    }
}
