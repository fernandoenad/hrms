@extends('layouts.app')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Welcome!')}}</h1>
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

            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <h2>HRMS</h2>
                        <p>
                            “HRMS” stands for Human Resources Management System. 
                            It refers to a suite of software that organizations 
                            use to manage internal HR functions. From employee data 
                            management to payroll, recruitment, benefits, training, 
                            talent management, employee engagement, and employee 
                            attendance, HRMS software helps HR professionals manage 
                            the modern workforce. Also called 
                            a human resources information system (HRIS), HRMS 
                            systems put information about a company's most 
                            valuable assets in front of the people who need them.  
                            <blockquote>
                                https://www.oracle.com/in/human-capital-management/hrms/
                            </blockquote>                      
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-user-tie"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Employee Login</span>
                        <span class="info-box-number"><a href="/my" class="text-white">Access the app</a></span>
                    </div>
                </div>

                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-laptop-code"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">ICTU</span>
                        <span class="info-box-number"><a href="/ictu" class="text-white">Access the app</a></span>
                    </div>
                </div>

                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Personnel Services</span>
                        <span class="info-box-number"><a href="/ps" class="text-white">Access the app</a></span>
                    </div>
                </div>

                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-copy"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Records Section</span>
                        <span class="info-box-number"><a href="/rs" class="text-white">Access the app</a></span>
                    </div>
                </div>                           
            </div>

            <div class="col-md-3">
                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-swatchbook"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Planning Unit</span>
                        <span class="info-box-number"><a href="/pu" class="text-white">Access the app</a></span>
                    </div>
                </div>

                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-user-tag"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">DPSU</span>
                        <span class="info-box-number"><a href="/dpsu" class="text-white">Access the app</a></span>
                    </div>
                </div>

                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-building"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Office / District</span>
                        <span class="info-box-number"><a href="/office" onClick="alert('App in progress...'); return false;" class="text-white">Access the app</a></span>
                    </div>
                </div>

                <div class="info-box mb-3 bg-primary">
                    <span class="info-box-icon"><i class="fas fa-school"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Station / School</span>
                        <span class="info-box-number"><a href="/station" onClick="alert('App in progress...'); return false;" class="text-white">Access the app</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection