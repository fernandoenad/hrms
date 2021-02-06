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
                    <td>{{ $person->employee->empno ?? __('') }}</td>
                </tr>
                <tr>
                    <th>Hire Date</th>
                    <td>{{ $person->employee->hiredate ?? __('') }}</td>
                </tr>
                <tr>
                    <th>Last Appt Date</th>
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
        <br><br>

        @if(isset($person->employee->item))
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
                        <th>Item No.</th>
                        <td>
                            {{ $person->employee->item->itemno ?? __('') }}
                        </td>
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
                        <th>Salary Grade</th>
                        <td>{{ $person->employee->item->salarygrade ?? __('') }}</td>
                    </tr>
                    <tr>
                        <th>SG-Step</th>
                        <td>{{ $person->employee->step ?? __('') }}</td>
                    </tr>                            
                    <tr>
                        <th>Employment Status</th>
                        <td>{{ $person->employee->employmentstatus ?? __('') }}</td>
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
                    <tr>
                        <th>Deployment</th>
                        <td>
                            {{ $person->employee->item->deployment->station->name ?? __('') }}
                            ({{ $person->employee->item->deployment->station->code ?? __('') }})
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
                            @if(isset($person->employee->item->deployment->station->person_id))
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
        @else
            <div class="alert alert-warning">
                {{ __('Employee was already terminated effective ') }} {{ $person->employee->retirementdate ?? __('') }}.
            </div>
        @endif
    </div>
</div>