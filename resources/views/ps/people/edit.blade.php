@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Edit Profile')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.people') }}">People</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.people.show', $person->id) }}">Person</a></li>
                    <li class="breadcrumb-item active">Edit Profile</li>
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
            <div class="card card-primary">
                <div class="card-body">
                    <form method="POST" action="{{ route('ps.people.update', $person->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <h5>Personal Information</h5>
                        <div class="form-group row">
                            <label for="firstname" class="col-md-3 col-form-label text-md-right">{{ __('Firstname') }}</label>

                            <div class="col-md-8">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') ?? $person->firstname }}" autocomplete="firstname">

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

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
                                        <option value="{{ $extension->details }}" @if (old('extname') || $person->extname  == $extension->details) {{ 'selected' }} @endif>{{ $extension->details }}</option>
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
                                        <option value="{{ $sex->details }}" @if (old('sex') || $person->sex == $sex->details) {{ 'selected' }} @endif>{{ $sex->details }}</option>
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
                                <input id="emergencyrelation" type="text" class="form-control @error('emergencyrelation') is-invalid @enderror" name="emergencyrelation" value="{{ old('emergencyrelation') ?? $person->contact->emergencyrelation }}" autocomplete="emergencyrelation">
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
                                <input id="emergencyaddress" type="text" class="form-control @error('emergencyaddress') is-invalid @enderror" name="emergencyaddress" value="{{ old('emergencyaddress') ?? $person->contact->emergencyaddress }}" autocomplete="emergencyaddress">
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
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $person->user->email }}" autocomplete="email">

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
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') ?? $person->user->username }}" autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{ __('Update Employee') }}
                                    </button>
                                    <a href="{{ route('ps.people.show', $person->id) }}" class="btn btn-default">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.people._tools')
        </div>
    </div>
</div>
@endsection
