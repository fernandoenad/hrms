@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Employees</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item active">Employees</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
        @include('ps.employees._profile')
        </div>
        <div class="col-md-6">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card card-primary">
                <div class="card-body">
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
                                <td>{{ $employee->person->firstname }}</td>
                            </tr>
                            <tr>
                                <th>Middlename</th>
                                <td>{{ $employee->person->middlename }}</td>
                            </tr>
                            <tr>
                                <th>Lastname</th>
                                <td>{{ $employee->person->lastname }}</td>
                            </tr>
                            <tr>
                                <th>Ext. Name</th>
                                <td>{{ $employee->person->extname }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{ $employee->person->sex }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $employee->person->dob }} <small>({{ $employee->person->getAge() }})</small></td>
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
                                <td>{{ $employee->person->contact->primaryno ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Secondary Contact #') }}</th>
                                <td>{{ $employee->person->contact->secondaryno ?? __('') }}</td>
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
                                <td>{{ $employee->person->contact->emergencyperson ?? __('')}}</td>
                            </tr>
                            <tr>
                                <th>Relationship</th>
                                <td>{{ $employee->person->contact->emergencyrelation ?? __('')}}</td>
                            </tr>                                        
                            <tr>
                                <th>Address</th>
                                <td>{{ $employee->person->contact->emergencyaddress ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Contact #</th>
                                <td>{{ $employee->person->contact->emergencycontact ?? __('')}}</td>
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
                                <td>{{ $employee->person->user->email ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $employee->person->user->username ?? __('') }}</td>
                            </tr>                                        
                            <tr>
                                <th>Account creation date</th>
                                <td>{{ $employee->person->user->created_at ?? __('') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <br><br>

                    <h4>Employment Data</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="35%">Field</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Employee Number</th>
                                <td>{{ $employee->empno ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Hire Date</th>
                                <td>{{ $employee->hiredate ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Last Appt Date</th>
                                <td>{{ $employee->lastapptdate ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Last NOSI Date</th>
                                <td>{{ $employee->lastnosidate ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Retirement Date</th>
                                <td>{{ $employee->retirementdate ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Employment Status</th>
                                <td>{{ $employee->employmentstatus ?? __('') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <br><br>

                    <h4>Compensation and Benefit Information</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="35%">Field</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>TIN Number</th>
                                <td>{{ $employee->tinno ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>GSIS BP Number</th>
                                <td>{{ $employee->gsisbpno ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Pag-IBIG Member ID</th>
                                <td>{{ $employee->pagibigid ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Phil-Health Number</th>
                                <td>{{ $employee->philhealthno ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>DBP Account Number</th>
                                <td>{{ $employee->dbpaccountno ?? __('') }}</td>
                            </tr>
                        </tbody>
                    </table>    
                    <br><br>

                    <h4>Appointment Information</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="35%">Field</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Plantilla Item #</th>
                                <td>{{ $employee->item->itemno ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Creation Date</th>
                                <td>{{ $employee->item->creationdate ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Position</th>
                                <td>{{ $employee->item->position ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ $employee->item->employeetype ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Appointment Date</th>
                                <td>{{ $employee->item->appointmentdate ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>First Day</th>
                                <td>{{ $employee->item->firstdaydate ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Plantilla Owner</th>
                                <td>
                                    {{ $employee->item->station->name ?? __('') }}
                                    ({{ $employee->item->station->code ?? __('') }})
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br><br>

                    <h4>Station Information</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="35%">Field</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Station Type</th>
                                <td>{{ $employee->station->type ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Station Code/No</th>
                                <td>{{ $employee->station->code ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Station Name</th>
                                <td>
                                    {{ $employee->station->name ?? __('') }}
                                    ({{ $employee->station->code ?? __('') }})
                                </td>
                            </tr>
                            <tr>
                                <th>Services</th>
                                <td>{{ $employee->station->services ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Barangay</th>
                                <td>{{ $employee->station->address ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Station Head</th>
                                <td>
                                    @if(isset($employee->station->person_id))
                                        {{ $employee->station->person->getFullname() ?? __('') }}
                                    @else 
                                        {{ __('') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>District/Office Name</th>
                                <td>{{ $employee->station->office->name ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>Municipality</th>
                                <td>{{ $employee->station->office->town->name ?? __('') }}</td>
                            </tr>
                            <tr>
                                <th>District/Office Head</th>
                                <td>
                                    @if(isset($employee->station->office->person_id))
                                        {{ $employee->station->office->person->getFullname() ?? __('')  }}
                                    @else 
                                        {{ __('') }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.employees._tools')
        </div>
    </div>
</div>
@endsection
