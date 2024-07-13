@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Application Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications', $station->id) }}">Cycles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications.showcycle', [$station->id, $cycle]) }}">{{ $cycle }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications.showvacancy', [$station->id, $cycle, $vacancy->id]) }}">Applications</a></li>
                    <li class="breadcrumb-item active">Application Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">         
            <div class="col-md-9">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                        Application Code: <strong>{{ $application->application_code  }}</strong>
                    </div>
                
                    <div class="card-body p-0">
                        <table class="table m-0 table-hover ">
                            <tbody>
                                <tr>
                                    <th width="25%">Name</th>
                                    <td>{{ $application->getFullname() }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $application->getAddress() }}</td>
                                </tr>
                                <tr>
                                    <th>Age</th>
                                    <td>{{ $application->age }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ $application->gender }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ $application->civil_status }}</td>
                                </tr>
                                <tr>
                                    <th>Religion</th>
                                    <td>{{ $application->religion }}</td>
                                </tr>
                                <tr>
                                    <th>Disability</th>
                                    <td>{{ $application->disability }}</td>
                                </tr>
                                <tr>
                                    <th>Ethnic group</th>
                                    <td>{{ $application->ethnic_group }}</td>
                                </tr>
                                <tr>
                                    <th>Position title applied for</th>
                                    <td>{{ $application->vacancy->position_title }}</td>
                                </tr>
                            </tbody>
                        </table>     
                    </div>

                    <div class="card-footer p-2">
                        <a href="{{ route('ou.station.applications.edit', [$station, $cycle, $vacancy, $application]) }}" class="btn btn-primary">Modify</a>

                        <div class="float-right">
                            <a href="{{ route('ou.station.applications.showvacancy', [$station, $cycle, $vacancy]) }}" 
                            class="btn btn-info"><i class="fas fa-reply"></i> Back</a>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-3">
                @include('ou.station.applications._tools')
            </div>
        </div>
    </div>
</div>
@endsection