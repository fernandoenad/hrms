@extends('layouts.my')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">My Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('rms') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('my') }}">My Profile</a></li>
                    <li class="breadcrumb-item active">My Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('my._profile')
        </div>

        <div class="col-md-9">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#personal" data-toggle="tab">Personal</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contacts" data-toggle="tab">Contacts</a></li>
                        @if(isset($person->employee->item_id))
                        <li class="nav-item"><a class="nav-link" href="#erprofile" data-toggle="tab">ER Profile</a></li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <div class="post">
                                <h4>Personal Information</h4>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="20%">Field</th>
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
                            </div>
                        </div>
                        <div class="tab-pane" id="contacts">
                            <div class="post">
                                <h4>Contact Information</h4>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="25%">Type</th>
                                            <th>
                                                Details
                                                <a href="{{ route('my.contact.edit') }}" class="btn btn-primary btn-sm float-right">
                                                    <span class="fas fa-file-signature"></span>
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

                                <h4>Address Information</h4>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="25%">Type</th>
                                            <th>
                                                Details
                                                <a href="{{ route('my.address.edit') }}" class="btn btn-primary btn-sm float-right">
                                                    <span class="fas fa-file-signature"></span>
                                                    {{ __('Modify') }}
                                                </a>                                            
                                            </th>
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
                                <br>

                                <h4>Emergency Contact Information</h4>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="25%">Field</th>
                                            <th>
                                                Details
                                                <a href="{{ route('my.contact.edit') }}" class="btn btn-primary btn-sm float-right">
                                                    <span class="fas fa-file-signature"></span>
                                                    {{ __('Modify') }}
                                                </a>    
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $person->contact->emergencyperson}}</td>
                                        </tr>
                                        <tr>
                                            <th>Relationship</th>
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
                            </div>
                        </div>                        
                        <div class="tab-pane" id="erprofile">
                            <div class="post">
                                <h4>Employment Data</h4>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="30%">Field</th>
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
                                            <th width="30%">Field</th>
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

                                @if(isset($person->employee->item))
                                    <h4>Appointment Information</h4>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="30%">Field</th>
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
                                                <th>CSC Confirmation Date</th>
                                                <td>{{ $person->employee->item->confirmationdate ?? __('') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Plantilla Owner</th>
                                                <td>
                                                    {{ $person->employee->item->station->name ?? __('') }}
                                                    ({{ $person->employee->item->station->code ?? __('') }})
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Deployment</th>
                                                <td>
                                                    {{ $person->employee->item->deployment->station->name ?? __('') }}
                                                    ({{ $person->employee->item->deployment->station->code ?? __('') }})
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br> 

                                    <h4>Deployment Information</h4>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="30%">Field</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Station Type</th>
                                                <td>{{ $person->employee->item->deployment->station->type ?? __('') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Services</th>
                                                <td>{{ $person->employee->item->deployment->station->services ?? __('') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Barangay</th>
                                                <td>{{ $person->employee->item->deployment->station->address ?? __('') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Station Head</th>
                                                <td>
                                                    @if($person->employee->item->deployment->station->person_id)
                                                        {{ $person->employee->item->deployment->station->person->getFullname() ?? __('') }}
                                                    @else 
                                                        {{ __('') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>District/Office Name</th>
                                                <td>{{ $person->employee->item->deployment->station->office->name ?? __('') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Municipality</th>
                                                <td>{{ $person->employee->item->deployment->station->office->town->name ?? __('') }}</td>
                                            </tr>
                                            <tr>
                                                <th>District/Office Head</th>
                                                <td>
                                                    @if(isset($person->employee->item->deployment->station->office->person_id))
                                                        {{ $person->employee->item->deployment->station->office->person->getFullname() ?? __('')  }}
                                                    @else 
                                                        {{ __('') }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

