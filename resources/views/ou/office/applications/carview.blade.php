<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', '') }} | CAR Sheet</title>
    <style>
        @page {
            size: legal landscape; /* Set the page size to landscape orientation */
            margin: .5cm; /* Optionally adjust the page margins */
        }

        /* Add any additional styles for your content */
        body {
            font-family: Arial, sans-serif;
            padding: 0px;
        }

        /* Example styles for a table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td{
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-0">
        <h4 class="text-center mb-3" align="center">COMPARATIVE ASSESSMENT RESULT - REGISTRY OF QUALIFIED APPLICANTS (CAR-RQA)</h4>

        <small>
        <table>
            <tr>
                <td width="40%" align="left">Position: <strong>{{ $vacancy->position_title }}</strong></td>
                <td width="40%"></td>
                <td width="20%">Date of Final Deliberation: <strong>N/A</strong></td>
            </tr>
            <tr>
                <td align="left">District: <strong>{{ $office->name}} (DepEd Bohol)</strong></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        </small>

        <br>
        <small>
        <table border="1">
            <thead>
                <tr class="table-danger" align="center">
                    <td scope="col" colspan="2" rowspan="2"><strong>Name of Application<strong></td>
                    <td scope="col" rowspan="2" width="10%"><strong>Application Code<strong></td>
                    <td scope="col" colspan="7" width="8%"><strong>COMPARATIVE ASSESSMENT RESULTS<strong></td>
                    <td scope="col" rowspan="2" width="8%"><strong>Remarks<strong></td>
                    <td scope="col" colspan="2" width="5%"><strong><small>For Background Investigation (Y/N)</small><strong></td>
                    <td scope="col" rowspan="2" width="8%">
                        <strong><small><small>For Appointment</strong><br>To filed-out by the Appointing Officer/ Authority; Please sign opposite the name of the applicant)</small></small></td>
                    <td scope="col" rowspan="2" width="8%">
                        <strong><small>Status of Appointment</strong><br>(Based on availability of PBET/ LET/LEPT)</small></td>
                </tr>
                <tr class="table-danger" align="center">
                    <th scope="col" width="5%">Education</th>
                    <th scope="col" width="5%">Training</th>
                    <th scope="col" width="5%">Experience</th>
                    <th scope="col" width="5%">Rating</th>
                    <th scope="col" width="5%">COI</th>
                    <th scope="col" width="5%">NCOI</th>
                    <th scope="col" width="5%">Total</th>
                    <th scope="col" width="3%">Yes</th>
                    <th scope="col" width="3%">No</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1; @endphp 

                @foreach($assessments as $assessment)
                    @php 
                        $assessment_details = json_decode($assessment->assessment, true); 
                        $application = App\Models\Application2::where('id', '=', $assessment->application_id)->get()->first();
                        $total_points = 0;
                    @endphp 
                    <tr>
                        <td width="2%">{{ $i }}</td>
                        <td>{{ $application->getFullname() }}</td>
                        <td>{{ $application->application_code }}</td>
                        @foreach($assessment_details as $key => $value)
                                @php $total_points += is_numeric($value) ? $value : 0; @endphp
                                <td align="right">{{ is_numeric($value) ? $value : $total_points }}</td>
                        @endforeach
                        <td align="left">{{ $assessment->status == 2 ? 'Initial results only. / ' . end($assessment_details) :  end($assessment_details) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @php $i++; @endphp 
                @endforeach
            </tbody>
        </table>
        </small>

        <br>
        <small>
        <table>
            <tr>
                <td width="25%" align="left">Prepared by the District Ranking Committee
                    <br><em>(All members should affix signature)</em>
                    <br>
                    <br>
                    <br>

                </td>
                <td width="25%"></td>
                <td width="25%"></td>
                <td width="25%"></td>
            </tr>
            <tr align="center">
                <td>_______________________________<br>Name and Position<br>Member</td>
                <td>_______________________________<br>Name and Position<br>Member</td>
                <td>_______________________________<br>Name and Position<br>Member</td>
                <td>_______________________________<br>Name and Position<br>Chairperson</td>
            </tr>
        </table>
    </small>
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>