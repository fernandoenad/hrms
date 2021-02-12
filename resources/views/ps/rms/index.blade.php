@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">RMS Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item">RMS Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">  

    <div class="row">
        <div class="col-md-9">

            <div class="row">                
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">New Applications</span>
                            <span class="info-box-number">
                                <a href="{{ route('ps.employees') }}">
                                    {{ number_format(0, 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Pending Applications</span>
                            <span class="info-box-number">
                                <a href="{{ route('ps.employees') }}">
                                    {{ number_format(0, 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Confirmed Applications</span>
                            <span class="info-box-number">
                                <a href="{{ route('ps.items') }}">
                                    {{ number_format(0, 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
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
            </div>

            <div class="card card-primary card-outline">
                <div class="card-header">

                </div>
                <div class="card-body p-0">

                </div> 
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.rms._tools')
        </div>
    </div>
</div>
@endsection
