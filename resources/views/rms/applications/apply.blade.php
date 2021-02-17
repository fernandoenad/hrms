@extends('layouts.my')  

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Submit Application</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('rms') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rms.application') }}">My Application</a></li>
                    <li class="breadcrumb-item active">Submit Application</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="col-md-9">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        New Application
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('rms.application.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="schoolyear" class="col-md-3 col-form-label text-md-right">{{ __('Cycle') }}</label>

                            <div class="col-md-8">
                                <input readonly id="schoolyear" type="text" class="form-control @error('schoolyear') is-invalid @enderror" name="schoolyear" value="{{ old('schoolyear') ?? $cycle }}" autocomplete="schoolyear">

                                @error('schoolyear')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vacancy_id" class="col-md-3 col-form-label text-md-right">{{ __('Position') }}</label>

                            <div class="col-md-8">
                                <input id="vacancy_id" type="hidden" class="form-control @error('vacancy_id') is-invalid @enderror" name="vacancy_id" value="{{ old('vacancy_id') ?? $vacancy->id }}" autocomplete="vacancy_id">
                                <input readonly id="vacancy_name" type="text" class="form-control @error('vacancy_name') is-invalid @enderror" name="vacancy_name" value="{{ old('vacancy_name') ?? $vacancy->name }}" autocomplete="vacancy_name">

                                @error('vacancy_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if($vacancy->vacancylevel == 3)
                            <input id="station_id" type="hidden" class="form-control-file @error('station_id') is-invalid @enderror" name="station_id" value="{{ old('station_id') ?? 0 }}" autocomplete="station_id">
                            <input id="type" type="hidden" class="form-control-file @error('type') is-invalid @enderror" name="type" value="{{ old('type') ?? 'New' }}" autocomplete="type">
                            <input id="remarks" type="hidden" class="form-control-file @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') ?? '-' }}" autocomplete="remarks">

                            <div class="form-group row">
                                <label for="pertdoc_soft" class="col-md-3 col-form-label text-md-right"><small>{{ __('Pertinent Document (Softcopy)') }}</small></label>

                                <div class="col-md-8">
                                    <input id="pertdoc_soft" type="file" class="form-control-file @error('pertdoc_soft') is-invalid @enderror" name="pertdoc_soft" value="{{ old('pertdoc_soft') }}" autocomplete="pertdoc_soft">
                                    <small><em>Refer to the memorandum relevant to the job opening for details.</em></small>
                                    <small><em class="text-mute">
                                        <br>
                                        Note: If your file is more than 2MB, please only submit a scanned copy of your 
                                        omnibus certification, and email the rest of your pertinent papers (<strong>in a single
                                        PDF file</strong>) to <strong>bohol.hrms@deped.gov.ph</strong>. Use this subject line format:
                                        <strong>Position | Fullname | Application #</strong> (e.g. <strong>Chief | Juan dela Cruz | 
                                        1234567</strong>). The <strong>Application #</strong> will be generated after saving the application.

                                    </em></small>

                                    @error('pertdoc_soft')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif 
                        @if($vacancy->vacancylevel < 3)
                            <input id="pertdoc_soft" type="hidden" class="form-control-file @error('pertdoc_soft') is-invalid @enderror" name="pertdoc_soft" value="{{ old('pertdoc_soft') ?? '-' }}" autocomplete="pertdoc_soft">

                            <div class="form-group row">
                                <label for="station_id" class="col-md-3 col-form-label text-md-right">{{ __('School Applied For') }}</label>

                                <div class="col-md-8">
                                    <select id="station_id" type="text" class="form-control @error('station_id') is-invalid @enderror" name="station_id" value="{{ old('station_id') }}" autocomplete="station_id">
                                    <option value="">Select</option>
                                        @foreach($stations as $station)
                                        <option value="{{ $station->id }}" @if(old('station_id') == $station->id){{ 'selected'}} @endif>{{ $station->code }}- {{ $station->name }}, {{ $station->office->name }} ({{ $station->office->town->name }})</option>
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
                                <label for="type" class="col-md-3 col-form-label text-md-right">{{ __('Application Type') }}</label>

                                <div class="col-md-8">
                                    <select id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" autocomplete="type">
                                    <option value="">Select</option>
                                        @foreach($applicationtypes as $applicationtype)
                                        <option value="{{ $applicationtype->details }}" @if(old('type') == $applicationtype->details){{ 'selected'}} @endif>{{ $applicationtype->details }}</option>
                                        @endforeach
                                    </select>
                                    <small><small><em>Update- update on any criterion score; Retain- all previous criterion scores will be carried over.</em></small></small>

                                    @error('level')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="remarks" class="col-md-3 col-form-label text-md-right">{{ __('Remarks') }}</label>

                                <div class="col-md-8">
                                    <textarea id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" 
                                        value="{{ old('remarks') }}" placeholder="Indicate criterion/criteria you wish to be updated (e.g. Interview, etc)" 
                                        autocomplete="remarks"></textarea>
                                    
                                    @error('remarks')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            
                        @endif

                        <div class="form-group row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Save application') }}
                                </button>
                                <a href="{{ route('rms.application') }}" class="btn btn-default">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                        </form>
                    </div>                    
                </div>
            </div>

            <div class="col-md-3">
                @include('rms.dashboard._tools')
                @include('rms.applications._tools')
            </div>
        </div>
    </div>
</div>
@endsection