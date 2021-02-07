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
@endsection
