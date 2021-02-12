@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Vacancy Applicants</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms') }}">RMS</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms.applications') }}">All</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms.applications-show-cycle', $cycle) }}">Cycle</a></li>
                    <li class="breadcrumb-item">Vacancy Applicants</li>
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
                <div class="card-body">
                    <span class="badge badge-success float-right">
                        {{ $applications->count() }} Applicant(s)
                    </span>

                    <h3>
                        <a href="{{ route('ps.rms.vacancies-show', $vacancy->id) }}">
                            {{ $vacancy->name ?? '' }} (Cycle {{ $cycle }})
                        </a>
                    </h3>  
                    
                    <span class="badge badge-mute text-left p-0">
                        Salary Grade: {{ $vacancy->salarygrade ?? '' }} | 
                        Vacancy Level: {{ $vacancy->getvacancylevel($vacancy->vacancylevel) ?? '' }} |
                        Curricular Level: {{ $vacancy->curricularlevel ?? '' }} |
                        Vacancy: {{ $vacancy->vacancy ?? '' }} slot(s) | 
                        Status: <span class="badge badge-{{ $vacancy->getstatuscolor($vacancy->status) ?? '' }}">{{ $vacancy->getstatus($vacancy->status) ?? '' }}</span>
                        <br>
                        Posted at {{ date('M d, Y h:i A', strtotime($vacancy->created_at )) }},
                        Updated at {{ date('M d, Y h:i A', strtotime($vacancy->updated_at )) }}
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
                                    <th>Contact / Address</th> 
                                    <th>Position / Station / District</th>                                    
                                    <th>Submitted at / Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($applications) > 0)
                                    <?php $i=1;?>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <a href="">
                                                    <strong>{{ $application->person->getFullnameBox() ?? '' }}</strong>
                                                </a>
                                            </td>
                                            <td>
                                                {{ $application->person->contact->primaryno ?? '' }}<br>
                                                {{ $application->person->address->current ?? '' }}                                            
                                            </td>
                                            <td>
                                                {{ $application->person->employee->item->position ?? 'No employment record' }}<br>
                                                {{ $application->person->employee->item->deployment->station->name ?? '' }}<br>
                                                {{ $application->person->employee->item->deployment->station->office->name ?? '' }}
                                            </td>
                                            <td>
                                                <span class="badge badge-default">
                                                    {{ date('M d, Y h:i a', strtotime($application->created_at)) ?? '' }}
                                                </span>    
                                                <br>
                                                <span class="badge badge-{{ $application->getstatuscolor($application->status) ?? '' }}">
                                                    {{ $application->getStatus($application->status) ?? '' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <?php $i++;?>
                                    @endforeach
                                @else
                                    <tr><td colspan="4">No record found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.rms._tools')
        </div>
    </div>
</div>
@endsection
