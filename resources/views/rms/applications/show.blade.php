@extends('layouts.my')  

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Application</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('rms') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rms.application') }}">My Application</a></li>
                    <li class="breadcrumb-item active">Application</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            @endif

            <div class="col-md-9">
                <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                        Application #<strong>{{ $application->code ?? '' }}</strong>
                        <span class="float-right">
                            <a href="{{ route('rms.application') }}"><i class="fas fa-arrow-circle-left"></i> Back</a>
                        </span>
                    </div>
                
                    <div class="card-body pt-2">
                        <div class="row">
                            <div class="col-md-7">
                                <h2 class="lead"><b>{{ $application->person->getFullnameBox() ?? ''}}</b></h2>
                                <p class="text-muted text-sm">
                                    <b>Position: </b> {{ $application->vacancy->name ?? ''}} 
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
                                    @if($application->vacancy->vacancylevel < 3)
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-school"></i></span> School applied for: {{ $application->station->code ?? '' }}- {{ $application->station->name ?? '' }}</li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-user"></i></span> School head: {{ (isset($application->station->person) ? $application->station->person->getFullnameBox() : '') ?? '' }}</li>
                                    @else
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-paperclip"></i></span> Pertinent Document (Softcopy): <a href="{{ asset('storage/' . $application->pertdoc_soft) }}" target="_blank">{{ $application->pertdoc_soft ?? '' }}</a></li>
                                    @endif
                                </ul>
                                <br>
                            </div>
                            
                            <div class="col-md-5">
                                <div class="card-body bg-info text-center">
                                    @if($application->vacancy->vacancylevel == 3)
                                        It is important that you take note of this application number: 
                                        <strong>{{ $application->code ?? '' }}</strong>.
                                        Use this as your reference number for any inquiry or
                                        follow-up related to this application. 
                                    @else
                                        It is important that you print this application number: 
                                        <strong>{{ $application->code ?? '' }}</strong>
                                        to the folders you will be submitting to the 
                                        school/station applied for. 
                                    @endif
                                </div>
                                <br>
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

                                            @if($application->vacancy->vacancylevel == 3)
                                                <!--
                                                <li>
                                                    <div  class="icheck-primary d-inline ml-2">
                                                        <input type="checkbox" value="" name="todo6" id="todoCheck6" disabled>
                                                        <label for="todoCheck6"></label>
                                                    </div>
                                                    <span class="text">Educational Background</span>
                                                    <div class="tools">
                                                        <a href="#"><i class="fas fa-edit"></i></a>
                                                    </div>
                                                </li>
                                                -->
                                                @if(isset($application->person->employee))
                                                    <!--
                                                    <li>
                                                        <div  class="icheck-primary d-inline ml-2">
                                                            <input type="checkbox" value="" name="todo6" id="todoCheck6" @if(isset($application->person->employee)) {{ 'checked'}} @endif disabled>
                                                            <label for="todoCheck6"></label>
                                                        </div>
                                                        <span class="text">Employment Record</span>
                                                    </li>
                                                    -->
                                                @else
                                                     <!--
                                                    <li>
                                                        <div  class="icheck-primary d-inline ml-2">
                                                            <input type="checkbox" value="" name="todo6" id="todoCheck6" @if(isset($application->person->employee)) {{ 'checked'}} @endif disabled>
                                                            <label for="todoCheck6"></label>
                                                        </div>
                                                        <span class="text">Employment Record</span>
                                                        <div class="tools">
                                                            <a href="#"><i class="fas fa-plus-square"></i></a>
                                                        </div>
                                                    </li>
                                                    -->
                                                @endif
                                                <!--
                                                <li>
                                                    <div  class="icheck-primary d-inline ml-2">
                                                        <input type="checkbox" value="" name="todo6" id="todoCheck6" disabled>
                                                        <label for="todoCheck6"></label>
                                                    </div>
                                                    <span class="text">Training History</span>
                                                    <div class="tools">
                                                        <a href="#"><i class="fas fa-edit"></i></a>
                                                    </div>
                                                </li>
                                                -->
                                                <li>
                                                    <div  class="icheck-primary d-inline ml-2">
                                                        <input type="checkbox" value="" name="todo6" id="todoCheck6" @if($application->pertdoc_soft != '-') {{ 'checked'}} @endif disabled>
                                                        <label for="todoCheck6"></label>
                                                    </div>
                                                    <span class="text">Pertinent Docs (Softcopy)</span>
                                                </li>
                                            @endif

                                            @if($application->vacancy->vacancylevel < 3)
                                                <li>
                                                    <div  class="icheck-primary d-inline ml-2">
                                                        <input type="checkbox" value="" name="todo6" id="todoCheck6" disabled>
                                                        <label for="todoCheck6"></label>
                                                    </div>
                                                    <span class="text">Pertinent Docs (Hardcopy)</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <form method="POST" action="{{ route('rms.application.destroy', $application->id) }}">
                            @csrf
                            @method('DELETE')

                            <button href="#" class="btn btn-sm btn-danger" @if($application->status != 1) {{ 'disabled' }} @endif
                                onClick="return confirm('This will delete your application which is IRREVERSIBLE. \nAre you sure wish to proceed?')">
                                <i class="fas fa-trash"></i> Withdraw Application
                            </button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-3">
                @include('rms.applications._tools')
            </div>
        </div>
    </div>
</div>
@endsection