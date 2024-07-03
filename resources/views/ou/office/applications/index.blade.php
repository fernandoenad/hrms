@extends('layouts.ouof')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Positions for the {{ $cycle }} Cycle</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">{{ $office->name ?? '' }}</a></li>
                    <li class="breadcrumb-item active">Positions</li>
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
            
            <div class="card card-outline card-primary">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>List</th>
                                    <th class="text-right">Pending </th>
                                    <th class="text-right">Completed </th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                                
                            <tbody>
                                @if(sizeof($vacancies) > 0)
                                    @foreach($vacancies as $vacancy)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ou.office.applications.show', [$office, $cycle, $vacancy])}}">
                                                    {{ $vacancy->position_title }}
                                                </a>
                                            </td>
                                            <td class="text-right">
                                                @php 
                                                    $assessments = Illuminate\Support\Facades\DB::connection('mysql_2')->table('assessments')
                                                        ->join('applications', 'assessments.application_id', '=', 'applications.id')
                                                        ->join('hrms.stations', 'applications.station_id', '=', 'stations.id')
                                                        ->where('stations.office_id', '=', $office->id)
                                                        ->where('applications.vacancy_id', '=', $vacancy->id)
                                                        ->where('assessments.status', '=', 2)
                                                        ->select('applications.*', 'stations.name')
                                                        ->get();
                                                @endphp
                                                {{ $assessments->count() }}
                                            </td>
                                            <td class="text-right">
                                                @php 
                                                    $assessments = Illuminate\Support\Facades\DB::connection('mysql_2')->table('assessments')
                                                        ->join('applications', 'assessments.application_id', '=', 'applications.id')
                                                        ->join('hrms.stations', 'applications.station_id', '=', 'stations.id')
                                                        ->where('stations.office_id', '=', $office->id)
                                                        ->where('applications.vacancy_id', '=', $vacancy->id)
                                                        ->where('assessments.status', '=', 3)
                                                        ->select('applications.*', 'stations.name')
                                                        ->get();
                                                @endphp
                                                {{ $assessments->count() }}
                                            </td>
                                            <td>
                                                @if($vacancy->level2_status == 1)
                                                    <span class="badge bg-success">Open</span>
                                                @elseif($vacancy->level2_status == 2)
                                                    <span class="badge bg-primary">Completed</span>
                                                @elseif($vacancy->level2_status == 3)
                                                    <span class="badge bg-info">Posted</span>
                                                @else 
                                                 <span class="badge bg-danger">Closed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No record was found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ou.office.applications._tools')
        </div>        
    </div>
</div>
@endsection

