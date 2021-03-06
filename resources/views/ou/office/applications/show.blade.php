@extends('layouts.ouof')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Application</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">{{ $office->name ?? '' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.applications', $office->id) }}">Cycles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.applications.showcycle', [$office->id, $cycle]) }}">{{ $cycle }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.applications.showvacancy', [$office->id, $cycle, $vacancy->id]) }}">Applications</a></li>
                    <li class="breadcrumb-item active">Application</li>
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

                @if(Route::currentRouteName() == 'ou.office.applications.show.take-action')
                    <div class="row">         
                        <div class="col-md-8 offset-md-2">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    Take Action
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('ou.office.applications.show.action-taken',  [$office->id, $cycle, $vacancy->id, $application->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="form-group row">
                                        <label for="status" class="col-md-3 col-form-label text-md-right">{{ __('Action') }}</label>

                                        <div class="col-md-8">
                                            <select id="application-status" type="text" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" autocomplete="status">
                                                <option value="2" @if(old('status') == 2 || $application->status == 2) {{ 'selected' }} @endif>Pending</option>
                                                <option value="3" @if(old('status') == 3 || $application->status == 3) {{ 'selected' }} @endif>Confirm</option>
                                                <option value="4" @if(old('status') == 4 || $application->status == 4) {{ 'selected' }} @endif>Deny</option>
                                            </select>
                                            @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="remarks" class="col-md-3 col-form-label text-md-right">{{ __('Remarks') }}</label>

                                        <div class="col-md-8">
                                            <textarea id="application-remarks" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="" autocomplete="remarks">{{ old('remarks') }}</textarea>

                                            @error('remarks')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-8">
                                            <button type="submit" class="btn btn-primary float-right">
                                                {{ __('Proceed') }}
                                            </button>
                                            <a href="{{ url()->previous() }}" class="btn btn-default">
                                                {{ __('Cancel') }}
                                            </a>
                                        </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                        Application #<strong>{{ $application->code ?? '' }}</strong>
                            <a href="{{ route('ou.office.applications.show.take-action', [$office->id, $cycle, $vacancy->id, $application->id]) }}"   
                                class="btn btn-primary float-right">Take Action</a>
                    </div>
                
                    <div class="card-body pt-2">
                        <div class="row">
                            <div class="col-md-7">
                                <img src="{{ asset('storage/avatars/' . $application->person->image) ?? '' }}" class="rounded-circle float-right" width="80">
                                <h2 class="lead"><b>{{ $application->person->getFullnameBox() ?? ''}}</b></h2>
                                <p class="text-muted text-sm">
                                    <b>Position: </b> {{ $application->vacancy->name ?? ''}} 
                                    <br>
                                    <b>Contact #: </b> {{ $application->person->contact->primaryno ?? ''}} 
                                    <br>
                                    <b>Curricular Level: </b> {{ $application->vacancy->curricularlevel ?? ''}} 
                                    <br>
                                    <b>Application Type: </b> {{ $application->type ?? '' }} 
                                    <br>
                                    <b>Status: </b> 
                                        <span class="badge badge-{{ $application->getStatusColor($application->status) ?? '' }}">
                                            {{ $application->getStatus($application->status) ?? '' }} 
                                        </span>
                                </p>
                                
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-school"></i></span> School applied for: {{ $application->station->code ?? '' }}- {{ $application->station->name ?? '' }}</li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-user"></i></span> School head: {{ (isset($application->station->person) ? $application->station->person->getFullnameBox() : '') ?? '' }}</li>
                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-paperclip"></i></span> Pertinent Document (Softcopy): <a href="{{ asset('storage/' . $application->pertdoc_soft) }}" target="_blank">{{ $application->pertdoc_soft ?? '' }}</a></li>
                                </ul>
                                <br>
                                
                            </div>
                            
                            <div class="col-md-5">
                                <div class="card">
                                    <div class="card-header">
                                        Application Checklist
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="todo-list" data-widget="todo-list">
                                            <li>
                                                <div  class="icheck-primary d-inline ml-2">
                                                    <input type="checkbox" value="" name="todo6" id="todoCheck6" checked disabled>
                                                    <label for="todoCheck6"></label>
                                                </div>
                                                <span class="text">Basic Information</span>
                                            </li>
                                            <li>
                                                <div  class="icheck-primary d-inline ml-2">
                                                    <input type="checkbox" value="" name="todo6" id="todoCheck6" @if($application->person->image != 'no-avatar.jpg') {{ 'checked'}} @endif disabled>
                                                    <label for="todoCheck6"></label>
                                                </div>
                                                <span class="text">Uploaded 2x2 ID Photo</span>
                                                <div class="tools">
                                                    <a href="{{ route('my.tools.image-edit') }}"><i class="fas fa-edit"></i></a>
                                                </div>
                                            </li>

                                            <li>
                                                <div  class="icheck-primary d-inline ml-2">
                                                    <input type="checkbox" value="" name="todo6" id="todoCheck6" @if($application->pertdoc_soft != '-') {{ 'checked'}} @endif disabled>
                                                    <label for="todoCheck6"></label>
                                                </div>
                                                <span class="text">Pertinent Docs (Softcopy)</span>
                                            </li>
                                            <li>
                                                <div  class="icheck-primary d-inline ml-2">
                                                    <input type="checkbox" value="" name="todo6" id="todoCheck6" @if($application->status == 3) {{ 'checked'}} @endif disabled>
                                                    <label for="todoCheck6"></label>
                                                </div>
                                                <span class="text">Confirmation</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Logs
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0 table-hover ">
                                <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Action</th> 
                                        <th width="40%">Remarks</th>                                    
                                        <th>Actor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($application->applicationlog) > 0)
                                        @foreach($application->applicationlog as $applicationlog)
                                            <?php $data = json_decode($applicationlog->log, true); ?>
                                            <tr>
                                                <td>{{ date('M d, Y h:i a', strtotime($applicationlog->created_at)) ?? ''}}</td>
                                                <td>{{ $applicationlog->action ?? '' }}</td>
                                                <td>{{ $data['remarks'] ?? '' }}</td>
                                                <td>{{ $applicationlog->user->name ?? ''}}</td>
                                            </tr>
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
                @include('ou.office.applications._tools')
            </div>
        </div>
    </div>
</div>
@endsection