@extends('layouts.my')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applications</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('rms') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rms.vacancy') }}">My Assignments</a></li>
                    <li class="breadcrumb-item">Applications</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">         
            <div class="col-md-9">
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
                            <small>
                            <table class="table m-0 table-hover ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>School</th>
                                        <th>District</th> 
                                        <th>Ranking File</th>                                    
                                        <th>Submitted at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($rankings) > 0)
                                        <?php $i=1;?>
                                        @foreach($rankings as $ranking)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $ranking->station->name ?? '' }} ({{ $ranking->station->code ?? '' }})</td>
                                                <td>{{ $ranking->station->office->name ?? '' }} (CD {{ $ranking->station->office->town->cdlevel ?? '' }})</td>
                                                <td><a href="{{ asset('storage') }}/{{ $ranking->attachment ?? '' }}" target="_blank"><i class="fas fa-download"></i></td>
                                                <td>{{ date('M d, Y h:i a', strtotime($ranking->created_at)) ?? '' }}</td>
                                            </tr>
                                            <?php $i++;?>
                                        @endforeach
                                    @else
                                        <tr><td colspan="5">No record found.</td></tr>
                                    @endif
                                </tbody>
                            </table>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                @include('rms.vacancies._tools')
            </div>
        </div>
    </div>
</div>
@endsection