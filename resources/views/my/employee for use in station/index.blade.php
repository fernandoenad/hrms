@extends('layouts.my')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Add Empoyment Record')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('my') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('my') }}">My Profile</a></li>
                    <li class="breadcrumb-item active">Add Empoyment Record</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                @include('my._profile')
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <p></p>
                    </div>
                        
                    <form method="POST" action="{{ route('my.employee-store') }}">
                        @csrf

                        <h4>Compensation and Benefit Information</h4>
                        <div class="form-group row">
                            <label for="empno" class="col-md-3 col-form-label text-md-right">{{ __('Employee No.') }}</label>

                            <div class="col-md-8">
                                <input id="empno" type="text" class="form-control @error('empno') is-invalid @enderror" name="empno" value="{{ old('empno') }}" autocomplete="empno">
                                <small><em class="text-danger">Your DepEd ID No.</em></small>

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
                                <input id="tinno" type="text" class="form-control @error('tinno') is-invalid @enderror" name="tinno" value="{{ old('tinno') }}" autocomplete="tinno">

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
                                <input id="gsisbpno" type="text" class="form-control @error('gsisbpno') is-invalid @enderror" name="gsisbpno" value="{{ old('gsisbpno') }}" autocomplete="gsisbpno">

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
                                <input id="pagibigid" type="text" class="form-control @error('pagibigid') is-invalid @enderror" name="pagibigid" value="{{ old('pagibigid') }}" autocomplete="pagibigid">

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
                                <input id="philhealthno" type="text" class="form-control @error('philhealthno') is-invalid @enderror" name="philhealthno" value="{{ old('philhealthno') }}" autocomplete="philhealthno  ">

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
                                <input id="dbpaccountno" type="text" class="form-control @error('dbpaccountno') is-invalid @enderror" name="dbpaccountno" value="{{ old('dbpaccountno') }}" autocomplete="dbpaccountno">

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
                                <input id="itemno" type="text" class="form-control @error('itemno') is-invalid @enderror" name="itemno" value="{{ old('itemno') }}" autocomplete="itemno">
                                <small><em class="text-danger">Item number (OSEC-DECSB-*-*) of the current appointment.</em></small>

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
                                <select id="step" type="text" class="form-control @error('step') is-invalid @enderror" name="step" value="{{ old('step') }}" autocomplete="step">
                                    <option value="">Select</option>
                                    @for($i=1; $i<=8; $i++)  
                                        <option value="{{ $i }}" @if(old('step') == $i) ? {{ 'selected' }} @endif >Step {{ $i }}</option>
                                    @endfor
                                </select>
                                <small><em class="text-danger">Salary Grade of the current appointment.</em></small>

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
                                <select id="employmentstatus" type="date" class="form-control @error('employmentstatus') is-invalid @enderror" name="employmentstatus" value="{{ old('employmentstatus') }}" autocomplete="employmentstatus">
                                    <option value="">Select</option>
                                    @foreach($employmentstatuses as $employmentstatus)
                                        <option value="{{ $employmentstatus->details }}" @if(old('employmentstatus') ==  $employmentstatus->details) {{ 'selected' }} @endif>{{ $employmentstatus->details }}</option>
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
                            <label for="station_id" class="col-md-3 col-form-label text-md-right">{{ __('Plantilla') }}</label>

                            <div class="col-md-8">
                                <select id="station_id" type="date" class="form-control @error('station_id') is-invalid @enderror" name="station_id" value="{{ old('station_id') }}" autocomplete="station_id">
                                    <option value="">Select</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}" @if(old('station_id') ==  $station->id) {{ 'selected' }} @endif>{{ $station->code }}- {{ $station->name }}, {{ $station->office->name }}</option>
                                    @endforeach
                                </select>

                                @error('station_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="station_id" class="col-md-3 col-form-label text-md-right">{{ __('Deployment') }}</label>

                            <div class="col-md-8">
                                <select id="station_id" type="date" class="form-control @error('station_id') is-invalid @enderror" name="station_id" value="{{ old('station_id') }}" autocomplete="station_id">
                                    <option value="">Select</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}" @if(old('station_id') ==  $station->id) {{ 'selected' }} @endif>{{ $station->code }}- {{ $station->name }}, {{ $station->office->name }}</option>
                                    @endforeach
                                </select>

                                @error('station_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="appointmentdate " class="col-md-3 col-form-label text-md-right">{{ __('Appt Date') }}</label>

                            <div class="col-md-8">
                                <input id="appointmentdate" type="date" class="form-control @error('appointmentdate') is-invalid @enderror" name="appointmentdate" value="{{ old('appointmentdate') }}" autocomplete="appointmentdate">
                                <small><em class="text-danger">Appointment date of the current appointment.</em></small>

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
                                <input id="firstdaydate" type="date" class="form-control @error('firstdaydate') is-invalid @enderror" name="firstdaydate" value="{{ old('firstdaydate ') }}" autocomplete="firstdaydate">
                                <small><em class="text-danger">First day date of the current appointment.</em></small>

                                @error('firstdaydate')
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
                                <input id="hiredate " type="date" class="form-control @error('hiredate') is-invalid @enderror" name="hiredate" value="{{ old('hiredate') }}" autocomplete="hiredate">
                                <small><em class="text-danger">Original appointment date.</em></small>
                                
                                @error('hiredate')
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
                                            <input id="lastnosidate_mark" name="lastnosidate_mark" type="checkbox">&nbsp; N/A
                                        </span>
                                    </div>
                                    <input id="lastnosidate" type="date" class="form-control @error('lastnosidate') is-invalid @enderror" name="lastnosidate" value="{{ old('lastnosidate') }}" autocomplete="lastnosidate">
                                </div>
                                <small><em class="text-danger">Leave N/A if no history.</em></small>

                                @error('lastnosidate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-3">   
                                <a href="{{ route('rms.application') }}" class="btn btn-default">
                                    {{ __('Cancel') }}
                                </a>                            
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Save employee information') }}
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

