@extends('layouts.ouof')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applications for the {{ $cycle }} Cycle</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office) }}">{{ $office->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.applications.index', [$office, $cycle]) }}">Positions</a></li>
                    <li class="breadcrumb-item active">Applications</li>
                    
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">         
            <div class="col-md-9">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card card-primary card-outline">
                <div class="card-body">
                    <span class="badge badge-success float-right">
                         {{ $applications->count() }} Applicant(s)
                    </span>
                    <span class="badge badge-mute text-left p-0">
                        <h4>{{ $vacancy->position_title }}</h4>
                    </span> 
                    
                </div> 
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="22%">Name</th>
                                    <th width="25%">Contact</th> 
                                    <th>School applied for</th>                                    
                                    <th>Status</th>
                                    <th width="17%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($applications) > 0)
                                    @php $i=1; @endphp
                                    @foreach($applications as $application)
                                        
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $application->last_name}}, {{ $application->first_name}}
                                                <br>
                                                <small>Code: {{ $application->application_code }}</small>
                                            </td>
                                            <td>{{ $application->barangay }}, {{ $application->municipality }}
                                                <br>{{ $application->phone }}
                                            </td>
                                            <td>{{ $application->code }}- {{ $application->name }}</td>
                                            <td>
                                                @php 
                                                    $assessment = DB::connection('mysql_2')->table('assessments')
                                                        ->join('applications', 'assessments.application_id', '=', 'applications.id')
                                                        ->join('hrms.stations', 'applications.station_id', '=', 'stations.id')
                                                        ->where('stations.office_id', '=', $office->id)
                                                        ->where('applications.vacancy_id', '=', $vacancy->id)
                                                        ->where('applications.id', '=', $application->id)
                                                        ->select('applications.*', 'stations.name', 'assessments.*')
                                                        ->first()
                                                @endphp
                                                {{ $assessment->status == 2 ? 'Pending' : ($assessment->status == 3 ? 'Completed' : 'Disqualified') }}
                                            </td>
                                            <td>
                                                @if($vacancy->level2_status == 1)
                                                    <a href="{{ route('ou.office.applications.assess', [$office, $cycle, $vacancy->id, $application->id])}}" 
                                                        class="btn btn-sm btn-primary" title="Assess">
                                                        <span class="fas fa-tasks fa-fw"></span>
                                                    </a>
                                                    <!--
                                                    <a href="{{ route('ou.office.applications.disqualify', [$office, $cycle, $vacancy->id, $application->id])}}" 
                                                        onclick="return confirm('This will tagged this application as DISQUALIFIED. Are you sure?')"
                                                        class="btn btn-sm btn-warning {{ $assessment->status == 3 || $assessment->status == 4 ? 'disabled' : '' }}" title="Disqualify">
                                                        <span class="fas fa-user-slash fa-fw"></span>
                                                    </a>
                                                    -->
                                                    <a href="{{ route('ou.office.applications.unmark', [$office, $cycle, $vacancy->id, $application->id])}}" 
                                                        onclick="return confirm('This will revert the application to PENDING. Are you sure?')"
                                                        class="btn btn-sm btn-danger {{ $assessment->status == 2 ? 'disabled' : '' }}" title="Revert">
                                                        <span class="fas fa-reply fa-fw"></span>
                                                    </a>
                                                @elseif($vacancy->level2_status == 2)
                                                    <span class="badge bg-primary">Completed</span>
                                                @elseif($vacancy->level2_status == 3)
                                                    <span class="badge bg-info">Posted</span>
                                                @else 
                                                    <span class="badge bg-danger">Closed</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                @else
                                    <tr><td colspan="7">No record found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>

            <div class="col-md-3">
                @include('ou.office.applications._tools')
            </div>
        </div>
    </div>
</div>
@endsection