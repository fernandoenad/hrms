@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Needs Confirmation</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }}</a></li>
                    <li class="breadcrumb-item active">Needs Confirmation</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">  

    <div class="row">
        <div class="col-md-9">

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
            <div class="card card-primary card-outline">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <small>
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact / Address</th> 
                                    <th>Position / Station / District</th>                                    
                                    <th>Submitted at / Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($applications) > 0)
                                    <?php $i=1;?>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <a href="{{ route('ou.station.applications.show', [$station->id, $application->schoolyear, $application->vacancy->id,  $application->id]) }}">
                                                    <strong>{{ $application->person->getFullnameBox() ?? '' }}</strong>
                                                </a>
                                            </td>
                                            <td>
                                                {{ $application->person->contact->primaryno ?? '' }}<br>
                                                {{ $application->person->address->current ?? '' }}                                            
                                            </td>
                                            <td>
                                                {{ $application->person->employee->item->position ?? 'No employment record' }}<br>
                                                {{ $application->person->employee->item->deployment->station->name ?? '' }}<br>
                                                {{ $application->person->employee->item->deployment->station->office->name ?? '' }}
                                            </td>
                                            <td>
                                                <span class="badge badge-default">
                                                    {{ date('M d, Y h:i a', strtotime($application->created_at)) ?? '' }}
                                                </span>    
                                                <br>
                                                <span class="badge badge-{{ $application->getstatuscolor($application->status) ?? '' }}">
                                                    {{ $application->getStatus($application->status) ?? '' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <?php $i++;?>
                                    @endforeach
                                @else
                                    <tr><td colspan="5">No record found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                        </small>
                    </div>
                </div> 
            </div>
        </div>

        <div class="col-md-3">
            @include('ou.station.applications._tools')
        </div>
    </div>
</div>
@endsection
