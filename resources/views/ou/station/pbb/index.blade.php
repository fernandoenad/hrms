@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">PBB Report {{ $year }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }} </a></li>
                    <li class="breadcrumb-item active">PBB Report {{ $year }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <small>
                        <strong class="text-danger">Reminders</strong>:
                        Only add an employee/ex-employee (eg. retired, terminated, deceased, transferred) on the list if the following criteria are met:
                        <ol>
                            <li>The employee/ex-employee rendered services between April {{ $year }} and March {{ $year + 1 }}.</li>
                            <li>The employee/ex-employee has rendered at least three months of service.</li>
                            <li>In case of a transferred employee/ex-employee, he/she will be added to the station where  
                                he/she spent most of the months within the period (April {{ $year }} - March {{ $year + 1 }}).</li>
                            <li>The required IPCR score is based on the approved IPCR result for SY {{ $year }}-{{ $year+1}}. </li>
                        </ol>
                        </small>
                </div>
            </div>

            <div class="card card-outline card-primary">
                <div class="card-header">
                    PBB List
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <small>
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="9%">Empl No.</th>
                                    <th width="25%">Name</th>
                                    <th width="10%">Months in Service</th>                                    
                                    <th>SG - Step</th>
                                    <th>IPCRF Score</th>
                                    <th>PBB Status</th>
                                    <th>Approval Status</th>
                                    <th></th>                               
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($pbblist) > 0)
                                    <?php $i=1;?>
                                    @foreach($pbblist as $pbb)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $pbb->empno ?? '' }}</td>
                                        <td>
                                            <strong>@if(isset($pbb->employee->person)) {{ $pbb->employee->person->getFullnameSorted() ?? '' }} @endif</strong>
                                        </td>
                                        <td>{{ $pbb->length_of_service ?? '' }}</td>
                                        <td>{{ $pbb->salary_grade ?? '' }} - {{ $pbb->step ?? '' }}</td>
                                        <td>{{ number_format($pbb->ipcr_score) ?? '' }}</td>
                                        <td>{{ $pbb->getpbbstatus($pbb->qualified) ?? '' }}</td>
                                        <td>{{ $pbb->getapprovaltatus($pbb->status) ?? '' }}</td>

                                        <td>
                                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                <a href="{{ route('ou.station.pbb.edit', [$station->id, $year, $pbb->id]) }}" class="dropdown-item">Modify</a>
                                                <a href="{{ route('ou.station.pbb.delete', [$station->id, $year, $pbb->id]) }}" class="dropdown-item">Remove</a>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12">
                                            {{ __('No record was found.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        </small>
                    </div>
                </div>
                <div class="card-footer p-2">
                    <span class="float-right"></span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ou.station.pbb._tools')
        </div>
    </div>
</div>
@endsection
