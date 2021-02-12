@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Vacancy</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms') }}">RMS Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms.vacancies') }}">Vacancies</a></li>
                    <li class="breadcrumb-item">Vacancy</li>
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
            <div class="card">
                <div class="card-body">
                    <button class="float-right btn btn-danger btn-sm" title="Delete Vacancy" href="{{ route('ps.rms.vacancies-destroy', $vacancy->id) }}" 
                        onclick="event.preventDefault();
                            if(confirm('This action is IRREVERSIBLE.\n Are you sure you wish to delete this vacancy?')){
                            document.getElementById('vacancy-delete').submit();} else {return false;}"
                            <?php $application_count = App\Models\Application::where('vacancy_id', '=', $vacancy->id)->count(); ?>
                            @if($application_count > 0){{ 'disabled'}} @endif>
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <a class="float-right btn btn-warning btn-sm mr-1" title="Modify Vacancy" href="{{ route('ps.rms.vacancies-edit', $vacancy->id) }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a class="float-right btn btn-default btn-sm mr-1" title="Back to Vacancies dashboard" href="{{ route('ps.rms.vacancies', $vacancy->type) }}">
                        <i class="fas fa-arrow-circle-left"></i>
                    </a>
                    <form id="vacancy-delete" method="POST" action="{{ route('ps.rms.vacancies-destroy', $vacancy->id) }}" class="d-none">
                    @csrf
                    @method('DELETE')
                    </form>
                    
                    <h3>{{ $vacancy->name ?? '' }}</h3>  
                    <span class="badge badge-mute p-0">
                        Posted at {{ date('M d, Y h:i A', strtotime($vacancy->created_at )) }},
                        Updated at {{ date('M d, Y h:i A', strtotime($vacancy->updated_at )) }}
                    </span> 

                    <p></p>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card-body bg-primary p-2">
                                Salary Grade: <strong>{{ $vacancy->salarygrade ?? '' }}</strong> <br>
                                Vacancy Level: <strong>{{ $vacancy->getvacancylevel($vacancy->vacancylevel) ?? '' }}</strong> <br>
                                Curricular Level: <strong>{{ $vacancy->curricularlevel ?? '' }}</strong><br>
                                Vacancy: <strong>{{ $vacancy->vacancy ?? '' }}</strong> slot(s)<br>
                                Status: <span class="badge badge-{{ $vacancy->getstatuscolor($vacancy->status) ?? '' }}">{{ $vacancy->getstatus($vacancy->status) ?? '' }}</span>
                            </div>
                            <br>

                            <div class="card card-primary">
                                <div class="card-body p-0">
                                    <ul class="nav nav-pills flex-column">
                                        <?php $cycles = App\Models\Application::where('vacancy_id', '=', $vacancy->id)
                                            ->groupBy('schoolyear')
                                            ->select('schoolyear')
                                            ->orderBy('schoolyear', 'desc')->get(); ?>

                                        @if(sizeof($cycles) > 0)
                                            @foreach($cycles as $cycle)
                                                <li class="nav-item">
                                                    <a href="{{ route('ps.rms.applications-show-vacancy', [$cycle->schoolyear, $vacancy->id]) }}" class="nav-link">
                                                        <i class="fas fa-inbox"></i> Cycle {{ $cycle->schoolyear ?? '' }}
                                                        <?php $appplicants = App\Models\Application::where('vacancy_id', '=', $vacancy->id)
                                                            ->where('schoolyear', '=', $cycle->schoolyear)
                                                            ->orderBy('schoolyear', 'desc')->count(); ?>
                                                        <span class="badge badge-success float-right">{{ $appplicants ?? '' }} applicant(s)</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-inbox"></i> No cycle found.
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body bg-default p-0">
                                <strong>Quality Standards</strong><br>
                                <?php echo  $vacancy->qualifications ?>
                            </div>
                        </div>
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
