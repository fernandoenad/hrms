@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Vacancy</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms') }}">RMS Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms.vacancies') }}">Vacancies</a></li>
                    <li class="breadcrumb-item active">New Vacancy</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            @if (session('status'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card card-primary card-outline">
                <div class="card-header">
                    New Vacancy
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('ps.rms.vacancies-store') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Position') }}</label>

                        <div class="col-md-8">
                            <input list="names" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}" autocomplete="name">
                            <datalist id="names">
                                @foreach($names as $name)
                                    <option value="{{ $name->name }}">
                                @endforeach
                            </datalist>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="salarygrade" class="col-md-3 col-form-label text-md-right">{{ __('Salary Grade') }}</label>

                        <div class="col-md-8">
                            <select id="salarygrade" type="text" class="form-control @error('salarygrade') is-invalid @enderror" name="salarygrade" value="{{ old('salarygrade') }}" autocomplete="salarygrade">
                                <option value="">Select</option>
                                @for($i=1; $i<=24; $i++)
                                    <option value="{{ $i }}" @if(old('salarygrade') ==  $i) {{ 'selected' }} @endif>{{ $i }}</option>
                                @endfor
                            </select>

                            @error('salarygrade')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="vacancylevel" class="col-md-3 col-form-label text-md-right">{{ __('Hiring Level') }}</label>

                        <div class="col-md-8">
                            <select id="vacancylevel" type="text" class="form-control @error('vacancylevel') is-invalid @enderror" name="vacancylevel" value="{{ old('vacancylevel') }}" autocomplete="vacancylevel">
                                <option value="">Select</option>
                                <option value="1" @if(old('vacancylevel') == 1) {{ 'selected' }} @endif>School</option>
                                <option value="2" @if(old('vacancylevel') == 2) {{ 'selected' }} @endif>District</option>
                                <option value="3" @if(old('vacancylevel') == 3) {{ 'selected' }} @endif>Division</option>
                            </select>

                            @error('vacancylevel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="curricularlevel" class="col-md-3 col-form-label text-md-right">{{ __('Curricular Level') }}</label>

                        <div class="col-md-8">
                            <select id="curricularlevel" type="text" class="form-control @error('curricularlevel') is-invalid @enderror" name="curricularlevel" value="{{ old('curricularlevel') }}" autocomplete="curricularlevel">
                                <option value="">Select</option>
                                @foreach($itemlevels as $itemlevel)
                                    <option value="{{ $itemlevel->details }}" @if(old('curricularlevel') == $itemlevel->details) {{ 'selected' }} @endif>{{ $itemlevel->details ?? '' }}</option>
                                @endforeach
                            </select>

                            @error('curricularlevel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>                    

                    <div class="form-group row">
                        <label for="qualifications" class="col-md-3 col-form-label text-md-right">{{ __('Qualifications') }}</label>

                        <div class="col-md-8">
                            <textarea id="mytextarea-vacancy" class="form-control @error('qualifications') is-invalid @enderror" name="qualifications" value="" autocomplete="qualifications">{{ old('qualifications') }}</textarea>

                            @error('qualifications')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="vacancy" class="col-md-3 col-form-label text-md-right">{{ __('Vacancy') }}</label>

                        <div class="col-md-8">
                            <input id="vacancy" type="number" class="form-control @error('vacancy') is-invalid @enderror" name="vacancy" value="{{ old('vacancy') }}" autocomplete="vacancy">

                            @error('vacancy')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>

                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-mute custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch3" type="number" class="form-control @error('status') is-invalid @enderror" name="status" value="1" autocomplete="status" @if(old('status') !== null) {{ 'checked' }} @else {{ '' }} @endif>
                                    <label class="custom-control-label" for="customSwitch3">Toggle to Close or Open (Green- Open; Gray- Close)</label>
                                </div>
                            </div>

                            @error('status')
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
                                    {{ __('Save Vacancy') }}
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-default">
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
            @include('ps.rms._tools')
        </div>
    </div>
</div>
@endsection
