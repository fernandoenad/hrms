@extends('layouts.ou')

@section('content')    
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Welcome to HRMS-OU!')}}</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <h2>HRMS OU</h2>
                        <p>
                            OU (Organizational Unit) is a feature of HRMS which allows users
                            to access the unit level organization or the office level organization.
                            <ul>
                                <li>
                                    Station / Unit - allows school heads / heads of units / provisioned
                                    users to access the unit level organization profile including
                                    but not limited to employee information, leave recommendations,
                                    etc... 
                                </li>
                                <li>
                                    Disrict / Office - allows district supervisors / heads of offices / 
                                    provisioned users to access the office level organization profile including
                                    but not limited to employee information, leave recommendations,
                                    etc... 
                                </li>
                            </ul>
       
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-home"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Bohol HRMS Home</span>
                        <span class="info-box-number"><a href="./" class="text-white">Back to Main</a></span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-school"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Station / Unit</span>
                        <span class="info-box-number"><a href="{{ route('ou.station') }}" class="text-white">Access the app</a></span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-sitemap"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">District / Office </span>
                        <span class="info-box-number"><a href="{{ route('ou.office') }}" class="text-white">Access the app</a></span>
                    </div>
                </div>
                              
            </div>
        </div>
    </div>
</div>
@endsection