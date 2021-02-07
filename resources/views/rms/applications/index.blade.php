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
                            <a href="{{ route('rms.application.create', $curr_term) }}" class="btn btn-success btn-md">Apply</a>
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
                                        <th>Specialization</th>
                                        <th>Station Code</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($curr_applications) > 0)
                                        @foreach($curr_applications as $curr_application)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('rms.application.show', $curr_application->id) }}">
                                                        <strong title="Submitted at {{ date('M d, Y', strtotime($curr_application->created_at)) ?? '' }}">
                                                            {{ $curr_application->code ?? '' }}
                                                        </strong>
                                                    </a>
                                                </td>
                                                <td>{{ $curr_application->position ?? '' }} / {{ $curr_application->type ?? '' }}</td>
                                                <td>{{ $curr_application->level ?? '' }}</td>
                                                <td>{{ $curr_application->major ?? '' }}</td>
                                                <td title="{{ $curr_application->station->name ?? '' }}, {{ $curr_application->station->office->name ?? '' }}">{{ $curr_application->station->code }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $curr_application->getStatusColor($curr_application->status) ?? ''}}">
                                                        {{ $curr_application->getStatus($curr_application->status) ?? '' }}
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

                <div class="card">
                    <div class="card-header">
                        Previous applications
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0 table-hover">
                                <thead>
                                    <tr>
                                        <th>Code</th>                                        
                                        <th>Position</th>
                                        <th>Level</th>
                                        <th>Specialization</th>
                                        <th>Station</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($prev_applications) > 0)
                                        @foreach($prev_applications as $prev_application)
                                            <tr>
                                                <td>
                                                <a href="{{ route('rms.application.show', $prev_application->id) }}">
                                                        <strong title="Submitted at {{ date('M d, Y', strtotime($prev_application->created_at)) ?? '' }}">
                                                            {{ $prev_application->code ?? '' }}
                                                        </strong>
                                                    </a>
                                                </td>
                                                <td>{{ $prev_application->position ?? '' }}  / {{ $curr_application->type ?? '' }}</td>
                                                <td>{{ $prev_application->level ?? '' }}</td>
                                                <td>{{ $prev_application->major ?? '' }}</td>
                                                <td title="{{ $prev_application->station->name ?? '' }}, {{ $prev_application->station->office->name ?? '' }}">{{ $curr_application->station->code }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $prev_application->getStatusColor($prev_application->status) ?? ''}}">
                                                        {{ $prev_application->getStatus($prev_application->status) ?? '' }}
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
                    <div class="card-footer p-0">
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