@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Plantilla</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.reports') }}">Reports</a></li>
                    <li class="breadcrumb-item active">Plantilla</li>
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
                                    <th>Head of Office</th>
                                    <th class="text-right">Station Count</th>
                                    <th class="text-right">Employee Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($offices) > 0)
                                    @foreach($offices as $office)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ps.reports.plantilla.office', $office->id) }}">
                                                    <strong>{{ $office->name }}</strong>
                                                </a>
                                            </td>
                                            <td>
                                                @if(isset($office->person))
                                                    <a href="{{ route('ps.people.show', $office->person->id ) }}">
                                                        {{ $office->person->getFullname() }}
                                                    </a>
                                                @else
                                                    {{ __('') }}
                                                @endif
                                            </td>
                                            <td class="text-right">{{ $office->station->count() }}</td>
                                            <td class="text-right">
                                                {{ \App\Http\Controllers\PS\ReportController::getEmployeesOffice($office->id, 'plantilla')->count() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th class="text-right">
                                            {{ number_format(\App\Http\Controllers\PS\ReportController::getStations()->count(), 0) }}
                                        </th>
                                        <th class="text-right">
                                            {{ number_format(\App\Http\Controllers\PS\ReportController::getEmployeesOffice('%', 'plantilla')->count(), 0) }}
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
