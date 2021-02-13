@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Item Information</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.items') }}">Items</a></li>
                    <li class="breadcrumb-item active">Item Information</li>
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
            <div class="card card-primary">
                <div class="card-body">
                    <span class="float-right">
                        <small><a href="#" data-toggle="modal" data-target="#modal-lg">Show Logs</a></small>
                    </span>

                    <h4>Item Details</h4>                 
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="35%">Field</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Item No.</th>
                                <td>{{ $item->itemno }}</td>
                            </tr>
                            <tr>
                                <th>Level</th>
                                <td>{{ $item->level }}</td>
                            </tr>
                            <tr>
                                <th>Creation Date</th>
                                <td>{{ $item->creationdate }}</td>
                            </tr>
                            <tr>
                                <th>Position</th>
                                <td>{{ $item->position }}</td>
                            </tr>
                            <tr>
                                <th>Salary Grade</th>
                                <td>{{ $item->salarygrade }}</td>
                            </tr>
                            <tr>
                                <th>Employment Type</th>
                                <td>{{ $item->employeetype }}</td>
                            </tr>
                            <tr>
                                <th>Appointment Date</th>
                                <td>{{ $item->appointmentdate }}</td>
                            </tr>
                            <tr>
                                <th>First Day Date</th>
                                <td>{{ $item->firstdaydate }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $item->status }}</td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td>{{ $item->remarks }}</td>
                            </tr>
                            <tr>
                                <th>Plantilla Owner</th>
                                <td>
                                    @if(isset($item->station))
                                        {{ $item->station->name }}
                                        ({{ $item->station->code }})
                                    @else
                                        {{ __('None') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Deployment</th>
                                <td>
                                    @if(isset($item->deployment->station))
                                        {{ $item->deployment->station->name }}
                                        ({{ $item->deployment->station->code }})
                                    @else
                                        {{ __('None') }}
                                    @endif
                                </td>
                            </tr>  
                        </tbody>
                    </table>
                    <br><br>

                    @if(isset($item->employee))
                    <h4>Deployment Details</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="35%">Field</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Employee</th>
                                <td>
                                    {{ $item->employee->person->getFullnameBox()}}
                                    ({{ $item->employee->empno }})
                                </td>
                            </tr>
                            <tr>
                                <th>Step</th>
                                <td>SG{{ $item->salarygrade }} - {{ $item->employee->step }}</td>
                            </tr>                         
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.items._tools')
        </div>
    </div>
</div>
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                Logs
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>Timestamp</th>
                                    <th>Action</th> 
                                    <th>Remarks</th>                                    
                                    <th>Actor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($itemlogs) > 0)
                                    @foreach($itemlogs as $itemlog)
                                        <?php $data = json_decode($itemlog->log, true); ?>
                                        <tr>
                                            <td>{{ date('M d, Y h:i a', strtotime($itemlog->created_at)) ?? ''}}</td>
                                            <td>{{ $itemlog->action ?? '' }}</td>
                                            <td>
                                                <div id="accordion">
                                                    <a class="text-primary" data-toggle="collapse" data-parent="#accordion" 
                                                        href="#collapseOne{{ $itemlog->id }}">
                                                        <i class="fas fa-plus-square"></i>
                                                    </a>
                                                    <div id="collapseOne{{ $itemlog->id }}" class="panel-collapse collapse in">
                                                        <small>
                                                            IN: <strong>{{ $data['itemno'] ?? '' }}</strong><br>
                                                            LE: <strong>{{ $data['level'] ?? '' }}</strong><br>
                                                            CD: <strong>{{ $data['creationdate'] ?? '' }}</strong><br>
                                                            POS: <strong>{{ $data['position'] ?? '' }}</strong><br>
                                                            SG: <strong>{{ $data['salarygrade'] ?? '' }}</strong><br>
                                                            ET: <strong>{{ $data['employeetype'] ?? '' }}</strong><br>
                                                            AD: <strong>{{ $data['appointmentdate'] ?? '' }}</strong><br>
                                                            FD: <strong>{{ $data['firstdaydate'] ?? '' }}</strong><br>
                                                            ST: <strong>{{ $data['status'] ?? '' }}</strong><br>
                                                            RE: <strong>{{ $data['remarks'] ?? '' }}</strong><br>
                                                            ST-I: <strong>{{ $data['station_id'] ?? '' }}</strong>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $itemlog->user->name ?? ''}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="4">No record found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
