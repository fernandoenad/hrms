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
                        Application #<strong>{{ $application->id  }}</strong>
                    </div>

                    <form method="post" action="{{ route('ou.station.applications.assess.update', [$station, $cycle, $vacancy, $application, $assessment]) }}">
                        @csrf 
                        @method('put')
                    <div class="card-body p-0">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $application->getFullname() }}</td>
                                </tr>
                                <tr>
                                    <th>Position title applied for</th>
                                    <td>{{ $application->vacancy->position_title }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $assessment->getStatus() }}</td>
                                </tr>
                                @php 
                                    $assessment_scores = json_decode($assessment->assessment);
                                    $assessment_template = json_decode($template->template, true);
                                @endphp 

                                @foreach($assessment_scores as $key => $value)
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <td>
                                            <div class="form-group">
                                                <input type="{{ is_numeric($value) ? 'number' : 'text' }}" class="form-control" placeholder="Enter significant remarks here (e.g., 4Ps, SPIMS, etc)" 
                                                    name="{{ $key }}" class="@error('{{ $key }}') is-invalid @enderror"
                                                    max="{{ $assessment_template[$key] }}"
                                                    step="{{ is_numeric($value) ? '0.001' : '' }}"
                                                    {{ $assessment->status > 1 || str_contains($key,'COI') ? 'readonly' :'' }}
                                                    value="{{ $value }}">
                                                @error($key)
                                                    <span class="text-danger"><small>{{ $message }}</small></span>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>     
                    </div>

                    <div class="card-footer p-2">
                        <button type="submit" class="btn btn-warning {{ $assessment->status > 1 ? 'disabled' :'' }}">Update</button>
                        <a href="{{ route('ou.station.applications.assess.markcomplete', [$station, $cycle, $vacancy, $application, $assessment]) }}" 
                            onclick="return confirm('Please hit the Modify button first before hitting the Mark Complete button. This will mark the assessment as complete and non-modifiable. You can revert this action via Applications. Are you sure?')"
                            class="btn btn-primary {{ $assessment->status > 1 ? 'disabled' :'' }}">Mark Complete</a>
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