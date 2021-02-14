@extends('layouts.station')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Station Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('station', ['1']) }}">Home</a></li>
                    <li class="breadcrumb-item active">Station Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ $station->name }} ({{ $station->code }})</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <strong>Address</strong>
                            <p>
                                {{ $station->address }}, 
                                {{ $station->office->name }}, 
                                {{ $station->office->town->name }}
                            </p>                            
                            <strong>Services</strong>
                            <p>{{ $station->services }}</p>                            

                            <strong>Head of Station</strong>
                            <p>{{ $station->person->getFullname() }}</p>

                            <strong>Head of Office</strong>
                            <p>{{ $station->office->person->getFullname() }}</p>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box mb-3 bg-primary">
                                <span class="info-box-icon"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Staff</span>
                                    <span class="info-box-number">{{ $station->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-info">
                <div class="card-header">{{ __('Administrative Tools') }}</div>

                <div class="card-body">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
