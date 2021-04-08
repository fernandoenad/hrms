@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ substr($vacancy->name, 0, 15) }}... Ranking</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms') }}">RMS</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms.applications') }}">All</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms.applications-show-cycle', $cycle) }}">Cycle</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms.applications-show-vacancy', [$cycle, $vacancy->id]) }}">Vacancy</a></li>
                    <li class="breadcrumb-item">{{ substr($vacancy->name, 0, 15) }}... Ranking</li>
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
                        <small>
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>School</th>
                                    <th>District</th> 
                                    <th>Ranking File</th>                                    
                                    <th>Submitted at</th>
                                    <th></th>
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
                                            <td><a href="{{ asset('storage') }}/{{ $ranking->attachment ?? '' }}" download><i class="fas fa-download"></i></td>
                                            <td>{{ date('M d, Y h:i a', strtotime($ranking->created_at)) ?? '' }}</td>
                                            <td>
                                                <a href="{{ route('ps.rms.applications-delete-ranking', [$cycle, $vacancy->id, $ranking->id]) }}" 
                                                    onclick="return confirm('This action is IRRVERSIBLE.\nAre you sure wish to delete this ranking submission?');">
                                                <i class="fas fa-trash-alt text-danger"></i></a>
                                            </td>
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
            @include('ps.rms._tools')
        </div>
    </div>
</div>
@endsection
