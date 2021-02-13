@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Employee</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.employees') }}">Employees</a></li>
                    <li class="breadcrumb-item active">Employee</li>
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

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card card-default">
                <div class="card-header">
                    Employment Logs
                    <span class="float-right">
                        <small><a href="{{ route('ps.employees.show', $person->employee->id) }}">Back to Profile</a></small>
                    </span>
                </div>
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
                                @if(sizeof($employeelogs) > 0)
                                    @foreach($employeelogs as $employeelog)
                                        <?php $data = json_decode($employeelog->log, true); ?>
                                        <tr>
                                            <td>{{ date('M d, Y h:i a', strtotime($employeelog->created_at)) ?? ''}}</td>
                                            <td>{{ $employeelog->action ?? '' }}</td>
                                            <td>
                                                <div id="accordion">
                                                    <a class="text-primary" data-toggle="collapse" data-parent="#accordion" 
                                                        href="#collapseOne{{ $employeelog->id }}">
                                                        <i class="fas fa-plus-square"></i>
                                                    </a>
                                                    <div id="collapseOne{{ $employeelog->id }}" class="panel-collapse collapse in">
                                                        <small>
                                                            EN: <strong>{{ $data['empno'] ?? '' }}</strong><br>
                                                            HD: <strong>{{ $data['hiredate'] ?? '' }}</strong><br>
                                                            S: <strong>{{ $data['step'] ?? '' }}</strong><br>
                                                            AD: <strong>{{ $data['lastapptdate'] ?? '' }}</strong><br>
                                                            ND: <strong>{{ $data['lastnosidate'] ?? '' }}</strong><br>
                                                            RD: <strong>{{ $data['retirementdate'] ?? '' }}</strong><br>
                                                            ES: <strong>{{ $data['employmentstatus'] ?? '' }}</strong><br>
                                                            TIN: <strong>{{ $data['tinno'] ?? '' }}</strong><br>
                                                            GSIS: <strong>{{ $data['gsisbpno'] ?? '' }}</strong><br>
                                                            PAG-I: <strong>{{ $data['pagibigid'] ?? '' }}</strong><br>
                                                            PH-H: <strong>{{ $data['philhealthno'] ?? '' }}</strong><br>
                                                            DBP: <strong>{{ $data['dbpaccountno'] ?? '' }}</strong><br>
                                                            ITEM: <strong>{{ $data['item_id'] ?? '' }}</strong>


                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $employeelog->user->name ?? ''}}</td>
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
        </div>

        <div class="col-md-3">
            @include('ps.people._tools')
        </div>
    </div>
</div>
@endsection
