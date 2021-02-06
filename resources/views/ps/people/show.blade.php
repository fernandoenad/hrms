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
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.people._tools')
        </div>
    </div>
</div>
@endsection
