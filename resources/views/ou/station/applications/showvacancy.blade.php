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

        @if(Route::currentRouteName() == 'ou.station.applications.upload-ranklist')
            <div class="row">         
                <div class="col-md-8 offset-md-2">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            Upload Ranklist
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('ou.station.applications.uploaded-ranklist', [$station->id, $cycle, $vacancy->id]) }}?ranking_id={{ $ranking_id }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="year" class="col-md-3 col-form-label text-md-right">{{ __('Cycle') }}</label>

                                <div class="col-md-8">
                                    <input readonly id="year" type="text" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year') ?? $cycle }}" autocomplete="year">

                                    @error('year')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="vacancy_id" class="col-md-3 col-form-label text-md-right">{{ __('Position') }}</label>

                                <div class="col-md-8">
                                    <input id="vacancy_id" type="hidden" class="form-control @error('vacancy_id') is-invalid @enderror" name="vacancy_id" value="{{ old('vacancy_id') ?? $vacancy->id }}" autocomplete="vacancy_id">
                                    <input readonly id="vacancy_name" type="text" class="form-control @error('vacancy_name') is-invalid @enderror" name="vacancy_name" value="{{ old('vacancy_name') ?? $vacancy->name }}" autocomplete="vacancy_name">

                                    @error('vacancy_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="attachment" class="col-md-3 col-form-label text-md-right">{{ __('Ranklist') }}</label>

                                <div class="col-md-8">
                                    <input id="attachment" type="file" class="form-control-file @error('attachment') is-invalid @enderror" name="attachment" value="{{ old('attachment') }}" autocomplete="attachment">
                                    <small><em>Please make sure this is already final.</em></small>       

                                    @error('attachment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" id="apply-submit" class="btn btn-primary float-right">
                                        {{ __('Upload') }}
                                    </button>
                                    <a href="{{ url()->previous() }}" class="btn btn-default">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

            <div class="card card-primary card-outline">
                <div class="card-body">
                    <span class="badge badge-success float-right">
                        {{ $applications->count() }} Applicant(s)
                    </span>

                    <h3>
                        <a href="{{ route('ou.station.applications.showvacancy', [$station->id, $cycle, $vacancy->id]) }}">
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
                                                <a href="{{ route('ou.station.applications.show', [$station->id, $application->schoolyear, $application->vacancy->id,  $application->id]) }}">
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
