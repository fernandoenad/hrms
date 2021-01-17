@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.users') }}">Users</a></li>
                    <li class="breadcrumb-item active">New User</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-body">
                    <form method="POST" action="{{ route('ps.users.store') }}">
                        @csrf

                        <h5>User Details</h5>
                        <div class="form-group row">
                            <label for="person_id" class="col-md-3 col-form-label text-md-right">{{ __('Employee') }}</label>

                            <div class="col-md-8">
                                <select id="person_id" type="text" class="form-control @error('person_id') is-invalid @enderror" name="person_id" value="{{ old('person_id') }}" autocomplete="person_id">
                                    <option value="">Select</option>
                                </select>

                                @error('person_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="person_id" class="col-md-3 col-form-label text-md-right">{{ __('Role') }}</label>

                            <div class="col-md-8">
                                <select id="person_id" type="text" class="form-control @error('person_id') is-invalid @enderror" name="person_id" value="{{ old('person_id') }}" autocomplete="person_id">
                                    <option value="">Select</option>
                                </select>

                                @error('person_id')
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
                                        {{ __('Save User') }}
                                    </button>
                                    <a href="{{ url()->previous()}}" class="btn btn-default">
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
