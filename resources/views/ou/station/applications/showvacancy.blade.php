@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applications</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications', $station->id) }}">Cycles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications.showcycle', [$station->id, $cycle]) }}">{{ $cycle }}</a></li>
                    <li class="breadcrumb-item active">Applications</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">  

    <div class="row">
        <div class="col-md-9">

            <div class="alert alert-warning">
                <p>
                Re: T1 Ranking Procedures<br>
                Dear School Heads,<br>
                Your tasks in the school level only include the following:<br>
                1) Preliminary assessment<br>
                - compare if original documents match with photocopies<br>
                - check if mandatory requirements are complied with to determine whether or not the applicant is qualified<br>
                2) Take in application<br>
                - take in the application using the application code via the school’s hrms portal<br>
                - mark completed by clicking the blue button<br>
                3) Pre-CAR<br>
                - print ICAR and sign<br>
                - prepare IES for each application<br>
                - bind folders of similar position<br>
                - submit to district for the CAR phase<br>
                <br>
                Please do not burden yourselves with the following:<br>
                - whether of nor the document is scorable (it is the job of the district ranking committee)<br>
                - the application is already completed and you can no longer input scores (it is the job of the district ranking committee)<br>
                And please do not abuse the use of the revert button, it is only used for incorrect take in. The goal is to only mark the application as “completed”
                Please review the T1 Ranking Guidelines for guidance. Thank you.
                </p>
            </div>
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
                                    <th>Name</th>
                                    <th>Contact</th> 
                                    <th>Address</th>                                    
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($applications) > 0)
                                    @php $i=1; @endphp
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $application->getFullname()}}<br>
                                                Code: {{ $application->application_code }}
                                            </td>
                                            <td>{{ $application->phone }}</td>
                                            <td>{{ $application->barangay }}, {{ $application->municipality }}</td>
                                            <td title="Submitted on {{ $application->updated_at->format('M d, Y H:ia') }}">
                                                @php 
                                                    $assessment = App\Models\Assessment::join('applications', 'applications.id', '=', 'assessments.application_id')
                                                        ->join('vacancies', 'applications.vacancy_id', '=', 'vacancies.id')
                                                        ->where('applications.vacancy_id', '=', $application->vacancy_id)
                                                        ->where('applications.station_id', '=', $station->id)
                                                        ->where('applications.id', '=', $application->id)
                                                        ->select('assessments.*')
                                                        ->get();
                                                @endphp
                                                {{ $assessment->count() == 0 ? 'New' :  ($assessment->first()->status == 1 ? 'Pending' : 'Completed') }}
                                                
                                                @if($vacancy->level1_status == 1)
                                                <a href="{{ route('ou.station.applications.revert', [$station, $cycle, $vacancy, $application]) }}" 
                                                    onclick="return confirm('This should only be used for valid reasons such as incorrect Take In. If the application is tagged as COMPLETED, that is by design as there is no inputting of scores in the school level. This sends a request to SDO-HR to revert status to New. Are you sure?')"
                                                    class="btn btn-sm btn-info float-right {{ $assessment->count() > 0 ? '' : 'disabled'}}" title="Revert to New">
                                                    <span class="fas fa-reply fa-fw"></span>
                                                </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('ou.station.applications.show', [$station, $cycle, $vacancy, $application]) }}"
                                                    class="btn btn-sm btn-warning" title="View/Edit Application">
                                                    <span class="fas fa-eye fa-fw"></span>
                                                </a>
                                                @if($vacancy->level1_status == 1)
                                                    <a href="{{ route('ou.station.applications.assess.index', [$station, $cycle, $vacancy, $application]) }}" 
                                                        class="btn btn-sm btn-primary" title="Assess">
                                                        <span class="fas fa-tasks fa-fw"></span>
                                                    </a>
                                                <a href="{{ route('ou.station.applications.withdraw', [$station, $cycle, $vacancy, $application])}}" 
                                                class="btn btn-sm btn-danger {{ $assessment->count() > 0 ? 'disabled' : '' }}" title="Withdraw"
                                                    onclick="return confirm('This will withraw the application. Are you sure?')">
                                                    <span class="fas fa-sign-out-alt fa-fw"></span>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <?php $i++;?>
                                    @endforeach
                                @else
                                    <tr><td colspan="5">No record found.</td></tr>
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


<div class="modal fade" id="progress-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content bg-default">
            <div class="modal-body">
                <strong class="text-center">Uploading media, please wait...</strong>
            </div>
            
        </div>
    </div>
</div>
@endsection
