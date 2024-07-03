@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applications for {{ $cycle }} Cycle</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications', $station->id) }}">Cycles</a></li>
                    <li class="breadcrumb-item active">{{ $cycle }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">  

    <div class="row">
        <div class="col-md-9">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
            <div class="card card-primary card-outline">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>Positions</th>
                                    <th class="text-right">Applications</th>
                                    <th class="text-right">Pending Assessment</th>
                                    <th class="text-right">Completed Assessment</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($applications) > 0)
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ou.station.applications.showvacancy', [$station, $cycle, $application->vacancy]) }} ">
                                                {{ App\Models\Vacancy2::find($application->vacancy_id)->position_title }}
                                                </a>
                                            </td>
                                            <td class="text-right">
                                                @php 
                                                    $application_count = App\Models\Application2::where('vacancy_id', '=', $application->vacancy_id)
                                                        ->where('station_id', '=', $station->id)->count();
                                                @endphp
                                                {{ $application_count }}
                                            </td>
                                            <td class="text-right">
                                                @php 
                                                    $application_count = App\Models\Assessment::join('applications', 'applications.id', '=', 'assessments.application_id')
                                                        ->join('vacancies', 'applications.vacancy_id', '=', 'vacancies.id')
                                                        ->where('applications.vacancy_id', '=', $application->vacancy_id)
                                                        ->where('applications.station_id', '=', $station->id)
                                                        ->where('assessments.status', '=', 1)
                                                        ->select('assessments.id')
                                                        ->count();
                                                @endphp
                                                {{ $application_count }}

                                            </td>
                                            <td class="text-right">
                                                @php 
                                                    $application_count = App\Models\Assessment::join('applications', 'applications.id', '=', 'assessments.application_id')
                                                        ->join('vacancies', 'applications.vacancy_id', '=', 'vacancies.id')
                                                        ->where('applications.vacancy_id', '=', $application->vacancy_id)
                                                        ->where('applications.station_id', '=', $station->id)
                                                        ->where('assessments.status', '>=', 2)
                                                        ->select('assessments.id')
                                                        ->count();
                                                @endphp
                                                {{ $application_count }}

                                            </td>
                                            <td>
                                                @if($application->vacancy->level1_status == 1)
                                                    <span class="badge bg-success">Open</span>
                                                @elseif($application->vacancy->level1_status == 2)
                                                    <span class="badge bg-primary">Completed</span>
                                                @else 
                                                    <span class="badge bg-danger">Closed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach 
                                @else 
                                    <tr><td colspan="4"><em>0 vacancies found.</em></tr>
                                @endif 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
            
        </div>

        <div class="col-md-3">
            @include('ou.station.applications._tools')
        </div>
    </div>
</div>
@endsection
