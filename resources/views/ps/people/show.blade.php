@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Non Employee</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.people') }}">Non Employees</a></li>
                    <li class="breadcrumb-item active">Non Employee</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('ps.people._profile')
        </div>
        <div class="col-md-6">
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
                    <h4>Personal Information</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="35%">Field</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Firstname</th>
                                <td>{{ $person->firstname }}</td>
                            </tr>
                            <tr>
                                <th>Middlename</th>
                                <td>{{ $person->middlename }}</td>
                            </tr>
                            <tr>
                                <th>Lastname</th>
                                <td>{{ $person->lastname }}</td>
                            </tr>
                            <tr>
                                <th>Ext. Name</th>
                                <td>{{ $person->extname }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{ $person->sex }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $person->dob }} <small>({{ $person->getAge() }})</small></td>
                            </tr>
                            <tr>
                                <th>Civil Status</th>
                                <td>{{ $person->civilstatus }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <br><br>

                    <h4>Contact Information</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="35%">Type</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>{{ __('Primary Contact #') }}</th>
                                <td>{{ $person->contact->primaryno ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Secondary Contact #') }}</th>
                                <td>{{ $person->contact->secondaryno ?? __('') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <br><br>

                    <h4>Address Information</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="25%">Type</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>{{ __('Current') }}</th>
                                <td>{{ $person->address->current }} ({{ $person->address->currentzip }})</td>
                            </tr>
                            <tr>
                                <th>{{ __('Permanent') }}</th>
                                <td>{{ $person->address->permanent }} ({{ $person->address->permanentzip }})</td>
                            </tr>
                        </tbody>
                    </table>
                    <br><br>

                    <h4>Emergency Contact Information</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="35%">Field</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $person->contact->emergencyperson ?? __('')}}</td>
                            </tr>
                            <tr>
                                <th>Relationship</th>
                                <td>{{ $person->contact->emergencyrelation ?? __('')}}</td>
                            </tr>                                        
                            <tr>
                                <th>Address</th>
                                <td>{{ $person->contact->emergencyaddress ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Contact #</th>
                                <td>{{ $person->contact->emergencycontact ?? __('')}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <br><br>

                    <h4>Account Information</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="35%">Field</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>E-Mail</th>
                                <td>{{ $person->user->email ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $person->user->username ?? __('') }}</td>
                            </tr>                                        
                            <tr>
                                <th>Account creation date</th>
                                <td>{{ $person->user->created_at ?? __('') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.people._tools')
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
                                @if(sizeof($personlogs) > 0)
                                    @foreach($personlogs as $personlog)
                                        <?php $data = json_decode($personlog->log, true); ?>
                                        <tr>
                                            <td>{{ date('M d, Y h:i a', strtotime($personlog->created_at)) ?? ''}}</td>
                                            <td>{{ $personlog->action ?? '' }}</td>
                                            <td>
                                                <div id="accordion">
                                                    <a class="text-primary" data-toggle="collapse" data-parent="#accordion" 
                                                        href="#collapseOne{{ $personlog->id }}">
                                                        <i class="fas fa-plus-square"></i>
                                                    </a>
                                                    <div id="collapseOne{{ $personlog->id }}" class="panel-collapse collapse in">
                                                        <small>
                                                            FN: <strong>{{ $data['firstname'] ?? '' }}</strong><br>
                                                            MN: <strong>{{ $data['middlename'] ?? '' }}</strong><br>
                                                            LN: <strong>{{ $data['lastname'] ?? '' }}</strong><br>
                                                            EXT: <strong>{{ $data['extname'] ?? '' }}</strong><br>
                                                            S: <strong>{{ $data['sex'] ?? '' }}</strong><br>
                                                            DOB: <strong>{{ $data['dob'] ?? '' }}</strong><br>
                                                            CS: <strong>{{ $data['civilstatus'] ?? '' }}</strong><br>
                                                            IMG: <strong>{{ $data['image'] ?? '' }}</strong>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $personlog->user->name ?? ''}}</td>
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
