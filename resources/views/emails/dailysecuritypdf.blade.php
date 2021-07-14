<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
	<title>Daily Security Report</title>
</head>
<style type="text/css">





@font-face {
    font-family: AR;
    src: url('public/fonts/AR.ttf');
    font-weight: bold;
    font-style: italic;
}


*{
     font-family: "AR";
}

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

.watermark {
  opacity: 0.15;
  position:fixed;
  display: block;
  padding-top: 50%;
  padding-left:10%;
  width: 75%;
}

.logo {
  width: 215px;
  height: 42px;
  margin: 0 11.7px 18.6px 2.6px;
}

</style>
<body >
    <img class="watermark" src="{{ url('/assets/wewatch_logo.png') }}">
    <div class="main">
    <table style="width:100%; " colspan="0" rowspan="0">
        <tr>
            <td class="logo" style="width:34%;"><img src="{{ url('/assets/wewatch_logo.png') }}" width="150px"></td>
            <td style="width:16%;"><img src="{{ url($security->project->project_logo) }}" width="100px" height="45.3543307092px"></td>
            <td style="width:16%; height:45.3543307092px;"><img src="{{ url('/assets/Logo1.jpg') }}" width="100px" height="45.3543307092px"></td>
            <td style="width:16%; height:45.3543307092px;"><img src="{{ url('/assets/Logo2.jpg') }}" width="100px" height="45.3543307092px"></td>
            <td style="width:16%; height:45.3543307092px;"><img src="{{ url('/assets/Logo3.jpg') }}" width="100px" height="45.3543307092px"></td>
        </tr>
    </table>
        <h1 style="text-align:center;">Daily Security Report</h1>
        <h3  class="color-red">EVENT/PROJECT NAME</h3>
        <h3   >{{ $security->project->project_name }}</h3>
        <h4  >{{ $security->date }}</h4>
        <br>
        <p  >{{ $security->description_confidential }}</p>
        {{-- <p class="color-red">Confidential</p> --}}
        <br>
        <h3><b>1. Daily Situation Summary</b></h3>
        <p  >{{ $security->daily_situation_summary }}</p>
        <br>
        <h3><b>2. Event / Project Details</b></h3>
        <table class="primary-table" colspan="0" rowspan="0">
            <tr>
                <th>Weather</th>
                <th>Wind Strength</th>
                <th>Remarks</th>
            </tr>
            <tr>
                <td>{{ $security->projectdetail[0]->weather }}</td>
                <td>{{ $security->projectdetail[0]->wind_strength }}</td>
                <td>{{ $security->projectdetail[0]->weather_wind_remarks }}</td>
            </tr>
        </table>

        <table class="primary-table top-margin-20" colspan="0" rowspan="0">
            <tr>
                <th>Design and Build Timings</th>
                <th>Daily Operations man-hour</th>
                <th>Remarks</th>
            </tr>
            <tr>
                <td>{{ $security->projectdetail[0]->design_build_time }}</td>
                <td>{{ $security->projectdetail[0]->daily_operation_man_hour }}</td>
                <td>{{ $security->projectdetail[0]->design_time_hour_remarks }}</td>
            </tr>
        </table>

        <table class="primary-table top-margin-20" colspan="0" rowspan="0">
            <tr>
                <th>Contractor Name</th>
                <th>Staff Numbers</th>
                <th>Shift Pattern</th>
                <th>Daily man-hours</th>
            </tr>
            @isset($security->projectdetail[0]->contractors)
            @foreach($security->projectdetail[0]->contractors as $cnotr)
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
            @isset($security->projectdetail[0]->type_contractors)
            @foreach($security->projectdetail[0]->type_contractors as $typecnotr)
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
                <td>{{ $security->projectdetail[0]->total_man_days }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Total man-hours</td>
                <td>{{ $security->projectdetail[0]->total_man_hours }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Total lost work hours</td>
                <td>{{ $security->projectdetail[0]->total_lost_work_hours }}</td>
            </tr>
        </table>
        <h3><b>3. Event / Project Key Meetings and Action Points</b></h3>
        <p>{{ $security->project_key_meeting }}</p>
        {{-- <p class="color-red">Confidential</p>
        <p>Prepared by WeWatch FZ LLC</p> --}}
        <br>
        <h3><b>4. Security Inductions and Briefings </b></h3>
        <p>{{ $security->toolbox_talk }}</p>
        <br>
        <h3><b>5. Security Incident / Accident or Near Miss Reporting</b></h3>
        <table class="primary-table" colspan="0" rowspan="0">
            <tr>
                <th>Occurence</th>
                <th>Yes or No</th>
                <th>Remarks</th>
            </tr>
            @foreach($security->nearmissreporting as $nearmiss)
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
        <h3><b>6. Security Management Plan and Sub-Contractor Security</b></h3>
        <p>{{ $security->security_management_plan }}</p>
        <br>
        <h3><b>7. Country Travel Security Assessment</b></h3>
        <p>{{ $security->country_travel_security }}</p>
        <br>
        {{-- <h3><b>8. Country Significant Acts of Terrorism/Crime (SIGACTS)</b></h3>
        <p>{{ $security->significant_acts_terrorism }}</p>
        <br> --}}
        <h3><b>8. Procurement Request</b></h3>
        <p>{{ $security->procurement_request }}</p>
        <br>
        <h3><b>9. Red Flag</b></h3>
        <p>{{ $security->red_flag }}</p>
        {{-- <p class="color-red">Confidential</p>
        <p>Prepared by WeWatch FZ LLC</p> --}}
        <br><br>
    </div>
</body>
</html>
