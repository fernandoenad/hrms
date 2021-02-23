@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Modify Employee</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.employees', $station->id) }}">Employees</a></li>
                    <li class="breadcrumb-item active">Modify Employee</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('ps.people._profile')
        </div>

        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h5>Modify Employment</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ps.employees.update', $person->employee->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="middlename" class="col-md-3 col-form-label text-md-right">{{ __('Middlename') }}</label>

                            <div class="col-md-8">
                                <input id="middlename" type="text" class="form-control @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename') ?? $person->middlename }}" autocomplete="middlename">

                                @error('middlename')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-3 col-form-label text-md-right">{{ __('Lastname') }}</label>

                            <div class="col-md-8">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') ?? $person->lastname }}" autocomplete="lastname">

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="extname" class="col-md-3 col-form-label text-md-right">{{ __('Ext. Name') }}</label>

                            <div class="col-md-8">
                                <select id="extname" type="text" class="form-control @error('extname') is-invalid @enderror" name="extname" value="{{ old('extname') }}" autocomplete="extname">
                                    <option value="">Select</option>
                                    @foreach($extensions as $extension)
                                        <option value="{{ $extension->details }}" @if (old('extname') == $extension->details || $person->extname  == $extension->details) {{ 'selected' }} @endif>{{ $extension->details }}</option>
                                    @endforeach
                                </select>
                                @error('extname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sex" class="col-md-3 col-form-label text-md-right">{{ __('Sex') }}</label>

                            <div class="col-md-8">
                                <select id="sex" type="text" class="form-control @error('sex') is-invalid @enderror" name="sex" value="{{ old('sex') }}" autocomplete="sex">
                                    <option value="">Select</option>
                                    @foreach($sexes as $sex)
                                        <option value="{{ $sex->details }}" @if (old('sex') == $sex->details || $person->sex == $sex->details) {{ 'selected' }} @endif>{{ $sex->details }}</option>
                                    @endforeach
                                </select>
                                @error('sex')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dob" class="col-md-3 col-form-label text-md-right">{{ __('Date of Birth') }}</label>

                            <div class="col-md-8">
                                <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') ?? date('Y-m-d', strtotime($person->dob)) }}" autocomplete="dob">

                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="civilstatus" class="col-md-3 col-form-label text-md-right">{{ __('Civil Status') }}</label>

                            <div class="col-md-8">
                                <select id="civilstatus" type="text" class="form-control @error('civilstatus') is-invalid @enderror" name="civilstatus" value="{{ old('civilstatus') }}" autocomplete="civilstatus">
                                <option value="">Select</option>
                                    @foreach($civilstatuses as $civilstatus)
                                        <option value="{{ $civilstatus->details }}" @if (old('civilstatus') == $civilstatus->details || $person->civilstatus == $civilstatus->details) {{ 'selected' }} @endif>{{ $civilstatus->details }}</option>
                                    @endforeach
                                </select>

                                @error('civilstatus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dob" class="col-md-3 col-form-label text-md-right">{{ __('Image') }}</label>

                            <div class="col-md-8">
                                <input id="image" type="file" class="form-control-file  @error('image') is-invalid @enderror" name="image" autocomplete="image">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h5>Contact Information</h5>
                        <div class="form-group row">
                            <label for="primaryno" class="col-md-3 col-form-label text-md-right">{{ __('Primary #') }}</label>

                            <div class="col-md-8">
                                <input id="primaryno" type="text" class="form-control @error('primaryno') is-invalid @enderror" name="primaryno" value="{{ old('primaryno') ?? $person->contact->primaryno }}" autocomplete="primaryno">
                                <small><em>{{ __('09xxxxxxxxx') }}</em></small>

                                @error('primaryno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="secondaryno" class="col-md-3 col-form-label text-md-right">{{ __('Secondary #') }}</label>

                            <div class="col-md-8">
                                <input id="secondaryno" type="text" class="form-control @error('secondaryno') is-invalid @enderror" name="secondaryno" value="{{ old('secondaryno') ?? $person->contact->secondaryno }}" autocomplete="secondaryno">
                                <small><em>{{ __('09xxxxxxxxx') }}</em></small>
                                @error('secondaryno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h5>Address Information</h5>
                        <div class="form-group row">
                            <label for="current" class="col-md-3 col-form-label text-md-right">{{ __('Current Addr') }}</label>

                            <div class="col-md-8">
                                <input list="currents" id="current" type="text" class="form-control @error('current') is-invalid @enderror" name="current" value="{{ old('current') ?? $person->address->current }}" autocomplete="current">
                                <datalist id="currents">
                                    @foreach($currents as $current)
                                        <option value="{{ $current->current ?? '' }}">
                                    @endforeach
                                </datalist>
                                <small><em>{{ __('Barangay, Town, Province') }}</em></small>

                                @error('current')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="currentzip" class="col-md-3 col-form-label text-md-right">{{ __('Curr Addr Zip') }}</label>

                            <div class="col-md-8">
                                <input id="currentzip" type="text" class="form-control @error('currentzip') is-invalid @enderror" name="currentzip" value="{{ old('currentzip') ?? $person->address->currentzip }}" autocomplete="currentzip">

                                @error('currentzip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="permanent" class="col-md-3 col-form-label text-md-right">{{ __('Perm Addr') }}</label>

                            <div class="col-md-8">
                                <input list="permanents" id="permanent" type="text" class="form-control @error('permanent') is-invalid @enderror" name="permanent" value="{{ old('permanent') ?? $person->address->permanent }}" autocomplete="permanent">
                                <datalist id="permanents">
                                    @foreach($permanents as $permanent)
                                        <option value="{{ $permanent->permanent ?? '' }}">
                                    @endforeach
                                </datalist>
                                <small><em>{{ __('Barangay, Town, Province') }}</em></small>

                                @error('permanent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="permanentzip" class="col-md-3 col-form-label text-md-right">{{ __('Perm Addr Zip') }}</label>

                            <div class="col-md-8">
                                <input id="permanentzip" type="text" class="form-control @error('permanentzip') is-invalid @enderror" name="permanentzip" value="{{ old('permanentzip') ?? $person->address->permanentzip }}" autocomplete="permanentzip">

                                @error('permanentzip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h5>Emergency Contact Information</h5>
                        <div class="form-group row">
                            <label for="emergencyperson" class="col-md-3 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-8">
                                <input id="emergencyperson" type="text" class="form-control @error('emergencyperson') is-invalid @enderror" name="emergencyperson" value="{{ old('emergencyperson') ?? $person->contact->emergencyperson }}" autocomplete="emergencyperson">

                                @error('emergencyperson')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emergencyrelation" class="col-md-3 col-form-label text-md-right">{{ __('Relationship') }}</label>

                            <div class="col-md-8">
                                <input list="emergencyrelations" id="emergencyrelation" type="text" class="form-control @error('emergencyrelation') is-invalid @enderror" name="emergencyrelation" value="{{ old('emergencyrelation') ?? $person->contact->emergencyrelation }}" autocomplete="emergencyrelation">
                                <datalist id="emergencyrelations">
                                    @foreach($relations as $relation)
                                        <option value="{{ $relation->emergencyrelation }}">
                                    @endforeach
                                </datalist>
                                <small><em>{{ __('Mother/Father, Husband/Wife, Sister/Brother, etc') }}</em></small>

                                @error('emergencyrelation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emergencyaddress" class="col-md-3 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-8">
                                <input list="emergencyaddresses" id="emergencyaddress" type="text" class="form-control @error('emergencyaddress') is-invalid @enderror" name="emergencyaddress" value="{{ old('emergencyaddress') ?? $person->contact->emergencyaddress }}" autocomplete="emergencyaddress">
                                <datalist id="emergencyaddresses">
                                    @foreach($addresses as $address)
                                        <option value="{{ $address->emergencyaddress }}">
                                    @endforeach
                                </datalist>
                                <small><em>{{ __('Barangay, Town, Province') }}</em></small>

                                @error('emergencyaddress')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emergencycontact" class="col-md-3 col-form-label text-md-right">{{ __('Contact #') }}</label>

                            <div class="col-md-8">
                                <input id="emergencycontact" type="text" class="form-control @error('emergencycontact') is-invalid @enderror" name="emergencycontact" value="{{ old('emergencycontact') ?? $person->contact->emergencycontact }}" autocomplete="emergencycontact">
                                <small><em>{{ __('09xxxxxxxxx') }}</em></small>
                                
                                @error('emergencycontact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h5>Account Information</h5>
                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-8">
                                <input @if($person->user->email_verified_at !== null) {{ 'readonly' }} @endif id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $person->user->email }}" autocomplete="email">
                                <small class="text-danger">@if($person->user->email_verified_at !== null) {{ 'Emails are no longer editable once verified.' }} @endif </small>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-3 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-8">
                                <input @if($person->user->email_verified_at !== null) {{ 'readonly' }} @endif id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') ?? $person->user->username }}" autocomplete="username">
                                <small class="text-danger">@if($person->user->email_verified_at !== null) {{ 'Usernames are no longer editable once verified.' }} @endif </small>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <h4>Compensation and Benefit Information</h4>
                        <div class="form-group row">
                            <label for="empno" class="col-md-3 col-form-label text-md-right">{{ __('Employee No.') }}</label>

                            <div class="col-md-8">
                                <input id="empno" type="text" class="form-control @error('empno') is-invalid @enderror" name="empno" value="{{ old('empno') ?? $person->employee->empno }}" autocomplete="empno">

                                @error('empno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tinno" class="col-md-3 col-form-label text-md-right">{{ __('TIN') }}</label>

                            <div class="col-md-8">
                                <input id="tinno" type="text" class="form-control @error('tinno') is-invalid @enderror" name="tinno" value="{{ old('tinno') ?? $person->employee->tinno }}" autocomplete="tinno">

                                @error('tinno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gsisbpno" class="col-md-3 col-form-label text-md-right">{{ __('GSIS') }}</label>

                            <div class="col-md-8">
                                <input id="gsisbpno" type="text" class="form-control @error('gsisbpno') is-invalid @enderror" name="gsisbpno" value="{{ old('gsisbpno') ?? $person->employee->gsisbpno }}" autocomplete="gsisbpno">

                                @error('gsisbpno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pagibigid" class="col-md-3 col-form-label text-md-right">{{ __('Pag-IBIG') }}</label>

                            <div class="col-md-8">
                                <input id="pagibigid" type="text" class="form-control @error('pagibigid') is-invalid @enderror" name="pagibigid" value="{{ old('pagibigid') ?? $person->employee->pagibigid }}" autocomplete="pagibigid">

                                @error('pagibigid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="philhealthno" class="col-md-3 col-form-label text-md-right">{{ __('Phil Health') }}</label>

                            <div class="col-md-8">
                                <input id="philhealthno" type="text" class="form-control @error('philhealthno') is-invalid @enderror" name="philhealthno" value="{{ old('philhealthno') ?? $person->employee->philhealthno }}" autocomplete="philhealthno  ">

                                @error('philhealthno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dbpaccountno" class="col-md-3 col-form-label text-md-right">{{ __('DBP Acct No.') }}</label>

                            <div class="col-md-8">
                                <input id="dbpaccountno" type="text" class="form-control @error('dbpaccountno') is-invalid @enderror" name="dbpaccountno" value="{{ old('dbpaccountno') ?? $person->employee->dbpaccountno }}" autocomplete="dbpaccountno">

                                @error('dbpaccountno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <h4>Appointment Information</h4>
                        <div class="form-group row">
                            <label for="itemno" class="col-md-3 col-form-label text-md-right">{{ __('Item No.') }}</label>

                            <div class="col-md-8">
                                <input readonly id="itemno" type="text" class="form-control @error('itemno') is-invalid @enderror" name="itemno" value="{{ old('itemno') ?? $person->employee->item->itemno}}" autocomplete="itemno">
                                <small><em>
                                    <strong>{{ $person->employee->item->position }}
                                    ({{ $person->employee->item->employeetype }}),  
                                    SG-{{ $person->employee->item->salarygrade }}</strong>
                                    &nbsp;
                                    <strong><a href="{{ route('ps.items.edit', $person->employee->item->id ) }}"><i class="fas fa-edit"></i></a></strong>
                                </em></small>

                                @error('itemno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="step" class="col-md-3 col-form-label text-md-right">{{ __('SG-Step') }}</label>

                            <div class="col-md-8">
                                <select id="step" type="text" class="form-control @error('step') is-invalid @enderror" name="step" value="{{ old('step') ?? $person->employee->step }}" autocomplete="step">
                                    <option value="">Select</option>
                                    @for($i=1; $i<=8; $i++)  
                                        <option value="{{ $i }}" @if(old('step') == $i || $person->employee->step == $i) ? {{ 'selected' }} @endif >Step {{ $i }}</option>
                                    @endfor
                                </select>
                                <small><em class="text-danger">Salary Grade Step. Only change this if need be.</em></small>

                                @error('step')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="employmentstatus " class="col-md-3 col-form-label text-md-right">{{ __('Empl Status') }}</label>

                            <div class="col-md-8">
                                <select id="employmentstatus" type="date" class="form-control @error('employmentstatus') is-invalid @enderror" name="employmentstatus" value="{{ old('employmentstatus') ??  $person->employee->employmenstatus }}" autocomplete="employmentstatus">
                                    <option value="">Select</option>
                                    @foreach($employmentstatuses as $employmentstatus)
                                        <option value="{{ $employmentstatus->details }}" @if(old('employmentstatus') ==  $employmentstatus->details ||  $person->employee->employmentstatus == $employmentstatus->details) {{ 'selected' }} @endif>{{ $employmentstatus->details }}</option>
                                    @endforeach
                                </select>

                                @error('employmentstatus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="appointmentdate " class="col-md-3 col-form-label text-md-right">{{ __('Appt Date') }}</label>

                            <div class="col-md-8">
                                <input id="appointmentdate" type="date" class="form-control @error('appointmentdate') is-invalid @enderror" name="appointmentdate" value="{{ old('appointmentdate') ?? date('Y-m-d', strtotime($person->employee->item->appointmentdate)) }}" autocomplete="appointmentdate">

                                @error('appointmentdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstdaydate" class="col-md-3 col-form-label text-md-right">{{ __('First Day') }}</label>

                            <div class="col-md-8">
                                <input id="firstdaydate" type="date" class="form-control @error('firstdaydate') is-invalid @enderror" name="firstdaydate" value="{{ old('firstdaydate ') ?? date('Y-m-d', strtotime($person->employee->item->firstdaydate)) }}" autocomplete="firstdaydate">

                                @error('firstdaydate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="confirmationdate" class="col-md-3 col-form-label text-md-right">{{ __('CSC Conf Date') }}</label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <input id="confirmationdate_mark" name="confirmationdate_mark" type="checkbox" @if($person->employee->confirmationdate == null) {{ 'checked' }} @endif>&nbsp;  N/A
                                        </span>
                                    </div>
                                    <input id="confirmationdate" type="date" class="form-control @error('confirmationdate') is-invalid @enderror" name="confirmationdate" value="{{ old('confirmationdate') ?? date('Y-m-d', strtotime($person->employee->confirmationdate)) }}" autocomplete="confirmationdate">
                                </div>
                                <small><em class="text-danger">Leave N/A if not yet confirmed by CSC.</em></small>

                                @error('confirmationdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>

                        <h4>Employment Data</h4>
                        <div class="form-group row">
                            <label for="hiredate" class="col-md-3 col-form-label text-md-right">{{ __('Hire Date') }}</label>

                            <div class="col-md-8">
                                <input id="hiredate " type="date" class="form-control @error('hiredate') is-invalid @enderror" name="hiredate" value="{{ old('hiredate') ?? date('Y-m-d', strtotime($person->employee->hiredate)) }}" autocomplete="hiredate">
                                <small><em class="text-danger">Original appointment date. Only change this if need be.</em></small>
                                
                                @error('hiredate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastapptdate" class="col-md-3 col-form-label text-md-right">{{ __('Last Appt') }}</label>

                            <div class="col-md-8">
                                <input id="lastapptdate" type="date" class="form-control @error('lastapptdate') is-invalid @enderror" name="lastapptdate" value="{{ old('lastapptdate') ?? date('Y-m-d', strtotime($person->employee->lastapptdate)) }}" autocomplete="lastapptdate">
                                <small><em class="text-danger">Last appointment date. Only change this if need be.</em></small>

                                @error('lastapptdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastnosidate" class="col-md-3 col-form-label text-md-right">{{ __('Last NOSI') }}</label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <input id="lastnosidate_mark" name="lastnosidate_mark" type="checkbox" @if($person->employee->lastnosidate == null) {{ 'checked' }} @endif>&nbsp; N/A
                                        </span>
                                    </div>
                                    <input id="lastnosidate" type="date" class="form-control @error('lastnosidate') is-invalid @enderror" name="lastnosidate" value="{{ old('lastnosidate') ?? date('Y-m-d', strtotime($person->employee->lastnosidate)) }}" autocomplete="lastnosidate">
                                </div>
                                <small><em class="text-danger">Leave N/A if no history.</em></small>

                                @error('lastnosidate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="retirementdate" class="col-md-3 col-form-label text-md-right">{{ __('Retirement') }}</label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <input id="retirementdate_mark" name="retirementdate_mark" type="checkbox" @if($person->employee->retirementdate == null) {{ 'checked' }} @endif>&nbsp;  N/A
                                        </span>
                                    </div>
                                    <input id="retirementdate" type="date" class="form-control @error('retirementdate') is-invalid @enderror" name="retirementdate" value="{{ old('retirementdate') ?? date('Y-m-d', strtotime($person->employee->retirementdate)) }}" autocomplete="retirementdate">
                                </div>
                                <small><em class="text-danger">Leave N/A if no history.</em></small>

                                @error('retirementdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Modify Employment') }}
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-default">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ou.station.employees._tools')
        </div>
    </div>
</div>
@endsection
