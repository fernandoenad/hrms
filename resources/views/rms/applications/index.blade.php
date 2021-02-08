@extends('layouts.my')  

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">My Application</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('rms') }}">Home</a></li>
                    <li class="breadcrumb-item active">My Application</li>
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
                
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        Current applications
                        <span class="float-right">
                            <a href="{{ route('rms.show', 'vacancies') }}">Check Vacancies</a>
                        </span>
                     </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0 table-hover">
                                <thead>
                                    <tr>
                                        <th>Code</th>                                        
                                        <th>Position</th>
                                        <th>Level</th>
                                        <th>Station Code</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($applications) > 0)
                                        @foreach($applications as $application)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('rms.application.show', $application->id) }}">
                                                        <strong title="Submitted at {{ date('M d, Y', strtotime($application->created_at)) ?? '' }}">
                                                            {{ $application->code ?? '' }}
                                                        </strong>
                                                    </a>
                                                </td>
                                                <td>{{ $application->vacancy->name ?? '' }} / {{ $application->type ?? '' }}</td>
                                                <td>{{ $application->vacancy->curricularlevel ?? '' }}</td>
                                                <td title="{{ $application->station->name ?? 'SDO Level' }}, {{ $application->station->office->name ?? 'SDO Level' }}">{{ $application->station->code ?? 'SDO' }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $application->getStatusColor($application->status) ?? ''}}">
                                                        {{ $application->getStatus($application->status) ?? '' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="6">No record found.</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer p-01">
                        <span class="float-right"></span>
                    </div>
                </div>
            </div>                

            <div class="col-md-3">
                @include('rms.applications._tools')
            </div>
        </div>
    </div>
</div>
@endsection