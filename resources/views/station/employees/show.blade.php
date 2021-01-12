@extends('layouts.station')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Employee</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('station', ['1']) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('station.employees', ['1']) }}">Employees</a></li>
                    <li class="breadcrumb-item active">Employee</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="row p-1">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        @include('my.profile')
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">

                        <div class="card-body">
                            <div class="post">
                                <h4>Personal Information</h4>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="25%">Field</th>
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
                                    </tbody>
                                </table>
                                <br> 

                                <h4>Contact Information</h4>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="40%">Type</th>
                                            <th>
                                                Details
                                                <a href="{{ route('my.contact.edit') }}" class="btn btn-primary btn-sm float-right">
                                                    <span class="fas fa-edit"></span>
                                                    {{ __('Modify') }}
                                                </a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>{{ __('Primary Contact #') }}</th>
                                            <td>{{ $person->contact->primaryno }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Secondary Contact #') }}</th>
                                            <td>{{ $person->contact->secondaryno }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>

                                <h4>Emergency Contact</h4>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="25%">Field</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Relationship</th>
                                            <td>{{ $person->contact->emergencyperson}}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $person->contact->emergencyrelation}}</td>
                                        </tr>                                        
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $person->contact->emergencyaddress}}</td>
                                        </tr>
                                        <tr>
                                            <th>Contact #</th>
                                            <td>{{ $person->contact->emergencycontact}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>

                                <h4>Employment Data</h4>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="40%">Field</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Employee Number</th>
                                            <td>{{ $person->employee->empno ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hire Date</th>
                                            <td>{{ $person->employee->hiredate ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last Appointment Date</th>
                                            <td>{{ $person->employee->lastapptdate ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last NOSI Date</th>
                                            <td>{{ $person->employee->lastnosidate ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Retirement Date</th>
                                            <td>{{ $person->employee->retirementdate ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Employment Status</th>
                                            <td>{{ $person->employee->employmentstatus ?? __('') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>

                                <h4>Compensation and Benefit Information</h4>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="40%">Field</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>TIN Number</th>
                                            <td>{{ $person->employee->tinno ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>GSIS BP Number</th>
                                            <td>{{ $person->employee->gsisbpno ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pag-IBIG Member ID</th>
                                            <td>{{ $person->employee->pagibigid ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phil-Health Number</th>
                                            <td>{{ $person->employee->philhealthno ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>DBP Account Number</th>
                                            <td>{{ $person->employee->dbpaccountno ?? __('') }}</td>
                                        </tr>
                                    </tbody>
                                </table>    
                                <br>

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
                                            <td>{{ $person->employee->item->itemno ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Creation Date</th>
                                            <td>{{ $person->employee->item->creationdate ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Position</th>
                                            <td>{{ $person->employee->item->position ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Type</th>
                                            <td>{{ $person->employee->item->employeetype ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Appointment Date</th>
                                            <td>{{ $person->employee->item->appointmentdate ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>First Day</th>
                                            <td>{{ $person->employee->item->firstdaydate ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Plantilla Owner</th>
                                            <td>
                                                {{ $person->employee->item->station->name ?? __('') }}
                                                ({{ $person->employee->item->station->code ?? __('') }})
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br> 

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
                                            <td>{{ $person->employee->item->station->type ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Station Code/No</th>
                                            <td>{{ $person->employee->item->station->code ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Station Name</th>
                                            <td>
                                                {{ $person->employee->item->station->name ?? __('') }}
                                                ({{ $person->employee->item->station->code ?? __('') }})
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Services</th>
                                            <td>{{ $person->employee->item->station->services ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Barangay</th>
                                            <td>{{ $person->employee->item->station->address ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Station Head</th>
                                            <td>{{ $person->employee->item->station->person->getFullname() ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>District/Office Name</th>
                                            <td>{{ $person->employee->item->station->office->name ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Municipality</th>
                                            <td>{{ $person->employee->item->station->office->town->name ?? __('') }}</td>
                                        </tr>
                                        <tr>
                                            <th>District/Office Head</th>
                                            <td>{{ $person->employee->item->station->office->person->getFullname() ?? __('') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-info">
                <div class="card-header">{{ __('Administrative Tools') }}</div>

                <div class="card-body">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
