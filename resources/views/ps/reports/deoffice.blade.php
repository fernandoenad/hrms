@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $office->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.reports') }}">Reports</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.reports.deployment') }}">Deployment</a></li>
                    <li class="breadcrumb-item active">{{ $office->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-primary">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Office</th>
                                    <th>Services</th>
                                    <th>School Head</th>                                    
                                    <th class="text-right">Employee Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($stations) > 0)
                                    @foreach($stations as $station)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ps.reports.deployment.station', [$office->id, $station->id])}}">
                                                    <strong>{{ $station->name }}</strong>
                                                </a>
                                                ({{ $station->code }})
                                            </td>
                                            <td>{{ $station->services }}</td>
                                            <td>
                                                @if(isset($station->person))
                                                    <a href="{{ route('ps.people.show', $station->person->id ) }}">
                                                        {{ $station->person->getFullname() }}
                                                    </a>
                                                @else
                                                    {{ __('') }}
                                                @endif
                                            </td>                                            
                                            <td class="text-right">
                                                {{ \App\Http\Controllers\PS\ReportController::getEmployeesStation($station->id, 'deployment')->count() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Total</th>
                                        <th>
                                            {{ $office->station->count() }}
                                            Stations
                                        </th>
                                        <th></th>
                                        <th class="text-right">
                                            {{ \App\Http\Controllers\PS\ReportController::getEmployeesOffice($office->id, 'deployment')->count() }}
                                        </th>
                                    </tr>
                                @else 
                                    <tr>
                                        <td colspan="4">No record was found.</td>
                                    </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.reports._tools')
        </div>
    </div>
</div>
@endsection
