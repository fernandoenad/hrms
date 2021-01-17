@extends('layouts.pu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pu') }}">Home</a></li>
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
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-map-marker"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Schools Districts</span>
                    <span class="info-box-number">
                        {{ number_format($district_count, 0) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-school"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Schools Stations</span>
                    <span class="info-box-number">
                        {{ number_format($school_count, 0) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-network-wired"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Offices</span>
                    <span class="info-box-number">
                        {{ number_format($office_count, 0) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-inbox"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Units/Sections</span>
                    <span class="info-box-number">
                        {{ number_format($unit_count, 0) }}
                    </span>
                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">{{ __('Filters') }}</div>

                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        @if(sizeof($offices) > 0)
                            @foreach($offices as $office)
                                <li class="nav-item">
                                    <a href="{{ route('pu.show', $office->id) }}" class="nav-link ">
                                        <i class="fas fa-circle"></i> {{ $office->name}}      
                                        <span class="badge badge-primary float-right">{{ $office->station->count() }} </span>             
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-circle"></i> {{ __('No record was found.')}}                   
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div> 

        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Station</th>
                                    <th>Tchr</th>
                                    <th class="text-right">Tchr</th>
                                    <th class="text-right" width="10%">N-Tchr</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($offices) > 0)
                                    @foreach($stations as $station)
                                        <tr>
                                            <td>
                                                <strong>{{ $station->name }} ({{ $station->code }}) </strong>
                                                <br> 
                                                {{ $station->office->name }}
                                            </td>
                                            <td>{{ $station->services }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\PUController::getEmployees($station->id, 'Teaching')->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\PUController::getEmployees($station->id, 'Non-Teaching')->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\PUController::getEmployees($station->id, '%')->count() }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">{{ __('No record was found.')}}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {!! $stations->render() !!}
                    </div>
                </div>
            </div>
        </div> 
    </div> 
@endsection
