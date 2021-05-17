<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
	<title>Daily HSE Report</title>
</head>
<style>
div.main{
    max-width:100%;
    width:100%;
}
.color-red{
    color:red;
}
.primary-table{
    width:100%;
    border:0.01px solid #717171;
    border-spacing: 0px;
}
.primary-table tr th, .primary-table tr td{
    text-align:left;
    padding:15px;
    border:0.01px solid #717171;
}
.primary-table tr th{
    background-color: #315AA5;
    color: white;
    font-weight:bold;
}
.top-margin-20{
    margin-top: 20px;
}
h3 {
    line-height: 0.4;
    margin-top: 30px;
}
</style>
<body>

    <div class="main">
    <table style="width:100%;" colspan="0" rowspan="0">
        <tr>
            <td style="width:34%;"><img src="{{ url('/assets/wewatch_logo.png') }}" width="200px"></td>
            <td style="width:16%;"><img src="{{ url($hse->project->project_logo) }}" width="100px" height="45.3543307092px"></td>
            <td style="width:16%; height:45.3543307092px;"><img src="{{ url('/assets/Logo1.jpg') }}" width="100px" height="45.3543307092px"></td>
            <td style="width:16%; height:45.3543307092px;"><img src="{{ url('/assets/Logo2.jpg') }}" width="100px" height="45.3543307092px"></td>
            <td style="width:16%; height:45.3543307092px;"><img src="{{ url('/assets/Logo3.jpg') }}" width="100px" height="45.3543307092px"></td>
        </tr>
    </table>
        <h1 style="text-align:center;">Daily HSE Report</h1>
        <h3 class="color-red">EVENT/PROJECT NAME</h3>
        <h3>{{ $hse->project->project_name }}</h3>
        <h4>{{ $hse->date }}</h4>
        <br>
        <p>{{ $hse->description_confidential }}</p>
        {{-- <p class="color-red">Confidential</p> --}}
        <br>
        <h3><b>1. Daily Situation Summary</b></h3>
        <p>{{ $hse->daily_situation_summary }}</p>
        <br>
        <h3><b>2. Event / Project Details</b></h3>
        <table class="primary-table" colspan="0" rowspan="0">
            <tr>
                <th>Weather</th>
                <th>Wind Strength</th>
                <th>Remarks</th>
            </tr>
            <tr>
                <td>{{ $hse->projectdetail[0]->weather }}</td>
                <td>{{ $hse->projectdetail[0]->wind_strength }}</td>
                <td>{{ $hse->projectdetail[0]->weather_wind_remarks }}</td>   
            </tr>
        </table>

        <table class="primary-table top-margin-20" colspan="0" rowspan="0">
            <tr>
                <th>Design and Build Timings</th>
                <th>Daily Operations man-hour</th>
                <th>Remarks</th>
            </tr>
            <tr>
                <td>{{ $hse->projectdetail[0]->design_build_time }}</td>
                <td>{{ $hse->projectdetail[0]->daily_operation_man_hour }}</td>
                <td>{{ $hse->projectdetail[0]->design_time_hour_remarks }}</td>   
            </tr>
        </table>

        <table class="primary-table top-margin-20" colspan="0" rowspan="0">
            <tr>
                <th>Contractor Name</th>
                <th>Staff Numbers</th>
                <th>Shift Pattern</th>
                <th>Daily man-hours</th>
            </tr>
            @isset($hse->projectdetail[0]->contractors)
            @foreach($hse->projectdetail[0]->contractors as $cnotr)
            <tr>
                <td>{{ $cnotr['contractors'] }}</td>
                <td>{{ $cnotr['staff_numbers'] }}</td>
                <td>{{ $cnotr['shift_pattern'] }}</td>
                <td>{{ $cnotr['daily_man_hours'] }}</td>   
            </tr>
            @endforeach
            @endisset
        </table>

        <table class="primary-table top-margin-20" colspan="0" rowspan="0">
            <tr>
                <th>Type of Contractor / Sub-Contractor</th>
                <th>Staff Numbers</th>
                <th>Shift Pattern</th>
            </tr>
            @isset($hse->projectdetail[0]->type_contractors)
            @foreach($hse->projectdetail[0]->type_contractors as $typecnotr)
            <tr>
                <td>{{ $typecnotr['type_contractors'] }}</td>
                <td>{{ $typecnotr['staff_numbers'] }}</td>
                <td>{{ $typecnotr['shift_pattern'] }}</td>   
            </tr>
            @endforeach
            @endisset
            <tr>
                <td></td>
                <td>TOTAL man-days</td>
                <td>{{ $hse->projectdetail[0]->total_man_days }}</td>   
            </tr>
            <tr>
                <td></td>
                <td>Total man-hours</td>
                <td>{{ $hse->projectdetail[0]->total_man_hours }}</td>   
            </tr>
            <tr>
                <td></td>
                <td>Total lost work hours</td>
                <td>{{ $hse->projectdetail[0]->total_lost_work_hours }}</td>   
            </tr>
        </table>
        <h3><b>3. Event / Project Key Meetings and Action Points</b></h3>
        <p>{{ $hse->project_key_meeting }}</p>
        {{-- <p class="color-red">Confidential</p> --}}
        {{-- <p>Prepared by WeWatch FZ LLC</p> --}}
        <br>
        <h3><b>4. Design/Build Activities in Progress</span></b></h3>
        <table class="primary-table" colspan="0" rowspan="0">
            <tr>
                <th>Occurence</th>
                <th>Yes or No</th>
                <th>Remarks</th>
            </tr>
            @foreach($hse->bulidactivity as $build)
            <tr>
                <td>{{ $build->activites }}</td>
                <td>{{ $build->occurrence }}</td>
                <td>{{ $build->remarks }}</td>   
            </tr>
            @endforeach
        </table>
        <h3><b>5. Security Inductions and Briefings </b></h3>
        <p>{{ $hse->toolbox_talk }}</p>
        <br>
        <h3><b>6. Event/Project Health, Safety and Environmental Compliance</b></h3>
        <table class="primary-table" colspan="0" rowspan="0">
            <tr>
                <th>Occurence</th>
                <th>Yes or No</th>
                <th>Remarks</th>
            </tr>
            @foreach($hse->projecthealthcompliance as $health)
            <tr>
                <td>{{ $health->project_health_activites }}</td>
                <td>{{ $health->project_health_occurrence }}</td>
                <td>{{ $health->project_health_remarks }}</td>   
            </tr>
            @endforeach
        </table>
        <h3><b>7. New Hazard Identified</span></b></h3>
        <table class="primary-table" colspan="0" rowspan="0">
            <tr>
                <th>Add to Event / Project Risk Assessment</th>
                <th>Yes or No</th>
                <th>Corrective Actions</th>
            </tr>
            @foreach($hse->hazardidentify as $hazard)
            <tr>
                <td>{{ $hazard->hazard_identify_activites }}</td>
                <td>{{ $hazard->hazard_identify_occurrence }}</td>
                <td>{{ $hazard->hazard_identify_remarks }}</td>   
            </tr>
            @endforeach
        </table>
        <h3><b>8. Security Incident / Accident or Near Miss Reporting</b></h3>
        <table class="primary-table" colspan="0" rowspan="0">
            <tr>
                <th>Occurence</th>
                <th>Yes or No</th>
                <th>Remarks</th>
            </tr>
            @foreach($hse->nearmissreporting as $nearmiss)
            <tr>
                <td>{{ $nearmiss->near_miss_activites }}</td>
                <td>{{ $nearmiss->near_miss_occurrence }}</td>
                <td>{{ $nearmiss->near_miss_remarks }}</td>   
            </tr>
            @endforeach
        </table>
        {{-- <p class="color-red">Confidential</p>
        <p>Prepared by WeWatch FZ LLC</p> --}}
        <br>
        <h3><b>9. COVID-19 Mitigation Compliance</b></h3>
        <table class="primary-table" colspan="0" rowspan="0">
            <tr>
                <th>Occurence</th>
                <th>Yes or No</th>
                <th>Remarks</th>
            </tr>
            @foreach($hse->covidcompliance as $covid)
            <tr>
                <td>{{ $covid->covid_compliance_activites }}</td>
                <td>{{ $covid->covid_compliance_occurrence }}</td>
                <td>{{ $covid->covid_compliance_remarks }}</td>   
            </tr>
            @endforeach
        </table>
        <h3><b>10. Procurement Request</b></h3>
        <p>{{ $hse->procurement_request }}</p>
        <br>
        <h3><b>11. Red Flag</b></h3>
        <p>{{ $hse->red_flag }}</p>
        {{-- <p class="color-red">Confidential</p>
        <p>Prepared by WeWatch FZ LLC</p> --}}
        <br><br>
    </div>
</body>
</html>