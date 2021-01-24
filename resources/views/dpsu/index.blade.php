@extends('layouts.dpsu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dpsu') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-inbox"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">NOSI Notifications</span>
                    <span class="info-box-number">
                        <a href="{{ route('pu.items.active') }}">
                            {{ number_format(0, 0) }}
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-inbox"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Loyalty Notifications</span>
                    <span class="info-box-number">
                        <a href="{{ route('pu.items.active') }}">
                            {{ number_format(0, 0) }}
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-coins"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Processing</span>
                    <span class="info-box-number">
                        <a href="{{ route('pu.items.active') }}">
                            {{ number_format(0, 0) }}
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-clipboard-list"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Completed</span>
                    <span class="info-box-number">
                        <a href="{{ route('pu.items.active') }}">
                            {{ number_format(0, 0) }}
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header pr-3">
                    Recent Requests
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Station Name (Code), District</th>
                                    <th>Request</th>
                                    <th>Date Requested</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
