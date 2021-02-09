@extends('layouts.app')

@section('content')    
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Request #{{ $accountrequest->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('help') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('help.track-requests') }}">Request Lookup</a></li>
                    <li class="breadcrumb-item active">Request #{{ $accountrequest->id }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                        Request #<strong>{{ $accountrequest->id ?? '' }}</strong>
                    </div>
                
                    <div class="card-body pt-2">
                        <div class="row">
                            <div class="col-md-7">
                                <h2 class="lead"><b>{{ $accountrequest->action ?? ''}}</b></h2>
                                <p class="text-muted text-sm">
                                    <b>Requester: </b> {{ (isset($accountrequest->person) ? $accountrequest->person->getFullnameBox() : 'Guest') ?? ''}}
                                    <br>
                                    <b>Remarks: </b> 
                                    <br>
                                    {{ $accountrequest->remarks ?? ''}}                                    
                                   
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <b>Status: </b> 
                            <span class="badge badge-{{ $accountrequest->getStatusColor($accountrequest->status) ?? '' }}">
                                {{ $accountrequest->getStatus($accountrequest->status) ?? '' }} 
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('home.requests._tools')
            </div>
        </div>
    </div>
</div>
@endsection