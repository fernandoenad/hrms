<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', '') }} | CAR Sheet</title>
    <style>
        .page-break {
            page-break-before: always;
        }

        @media print {
            @page {
                size: 8.5in 11in;
                margin: .3in;
            }
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
    <div class="container">
        @foreach($assessments as $assessment)
            @php    
                $application = App\Models\Application2::where('id', '=', $assessment->application_id)->get()->first();
            @endphp
            <div class="page-break">
                <h4 class="text-center mb-3" align="center">INDIVIDUAL EVALUATION SHEET</h4>
                <!--
                <div class="d-flex justify-content-end mb-4">
                    <a class="btn btn-primary" href="{{ route('ou.station.applications.showvacancy.pdf', [$station, $cycle, $vacancy])}}">Export to PDF</a>
                </div>
                -->
                <small>
                    <table>
                        <tr>
                            <td align="left">Name of Applicant: <strong>{{ $application->getFullname() }}</strong></td>
                            <td width="5"></td>
                            <td width="30%">Application Code: <strong>{{ $application->application_code }}</strong></td>
                        </tr>
                        <tr>
                        <td align="left">Position Applied For: <strong>{{ $vacancy->position_title }}</strong></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="left">School: <strong>{{ $station->code}}- {{ $station->name}} ({{ $station->office->name}})</strong></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="left">Contact Number: <strong>{{ $application->phone }}</strong></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="left">Remarks: _____________________________________</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>

                    <br>
                    <table border="1" height="500">
                        <tr bgcolor="lightgray">
                            <th rowspan="2">Criteria</th>
                            <th rowspan="2">Weight Allocation</th>
                            <th colspan="3">Applicant's Actual Qualifications</th>
                        </tr>
                        <tr bgcolor="lightgray">
                            <th>Details of Applicant's Qualifiation</th>
                            <th>Computation</th>
                            <th>Actual Score</th>
                        </tr>
                        <tr>
                            <td>Education</td>
                            <td align="center">10</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Training</td>
                            <td align="center">10</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Experience</td>
                            <td align="center">10</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Rating</td>
                            <td align="center">10</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>PPST COIs (Teaching-Demonstration)</td>
                            <td align="center">35</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>PPST NCOIs (Teaching-Reflection)</td>
                            <td align="center">25</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr bgcolor="lightgray">
                            <td>TOTAL</td>
                            <td align="center">100</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>

                    <br>
                    I hereby attest to the conduct of the application and assessment process in accordance with 
                    the applicable guidelines; and acknowledge, upon discussion with the Human Resource Merit 
                    Promotion and Selection Board (HRMPSB), the results of the comparative assessment and 
                    points given to me based on my qualifications and submitted documentary requirements for 
                    the <strong>{{ $vacancy->position_title }}</strong> position under DepEd Bohol.
                    <br>
                    <br>
                    Furthermore, I hereby affix my signature in this Form to attest to the objective and judicious 
                    conduct of the HRMPSB evaluation through Open Ranking System.
                    <br>
                    <br>
                    <br>
                    <br>

                    <table>
                        <tr>
                            <td align="left"></td>
                            <td width="5"></td>
                            <td width="30%" align="center">
                                _________________________________<br>
                                Name and Signature of Applicant<br>
                                Date: _______________
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <table>
                                    <tr>
                                        <td colspan="2" width="25%" align="left">Prepared by the School Ranking Committee
                                            <br><em>(All members should affix signature)</em>
                                            <br>
                                            <br>

                                        </td>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                    </tr>
                                    <tr align="center">
                                        <td>_______________________________<br>Name and Position<br>Member<br>Date: _______________</td>
                                        <td>_______________________________<br>Name and Position<br>Member<br>Date: _______________</td>
                                        <td>_______________________________<br>Name and Position<br>Member<br>Date: _______________</td>
                                        <td>_______________________________<br>Name<br>Chairperson<br>Date: _______________</td>
                                    </tr>
                                </table>
                                <br><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <table>
                                    <tr>
                                        <td colspan="2" width="25%" align="left">Prepared by the District Ranking Committee
                                            <br><em>(All members should affix signature)</em>
                                            <br>
                                            <br>
                                        </td>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                    </tr>
                                    <tr align="center">
                                        <td>_______________________________<br>Name and Position<br>Member<br>Date: _______________</td>
                                        <td>_______________________________<br>Name and Position<br>Member<br>Date: _______________</td>
                                        <td>_______________________________<br>Name and Position<br>Member<br>Date: _______________</td>
                                        <td>_______________________________<br>Name<br>Chairperson<br>Date: _______________</td>
                                    </tr>
                                </table>
                                <br><br><br>
                            </td>
                        </tr>
                    </table>
                </small>
            </div>
        @endforeach
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
    <script>
    window.onload = function() {
        window.print();
    };
</script>
</body>
</html>