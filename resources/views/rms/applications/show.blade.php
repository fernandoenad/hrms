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
                            <div class="col-7">
                                <h2 class="lead"><b>{{ $application->person->getFullnameBox() ?? ''}}</b></h2>
                                <p class="text-muted text-sm">
                                    <b>Specialization: </b> {{ $application->major ?? ''}} 
                                    <br>
                                    <b>Level: </b> {{ $application->level ?? ''}} 
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
                                </ul>
                            </div>
                            <div class="col-5 text-center">
                                <div class="card-body bg-info">
                                    It is important that you print this application number: 
                                    <strong>{{ $application->code ?? '' }}</strong>
                                    to the folders you will be submitting to the 
                                    school/station applied for. 
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