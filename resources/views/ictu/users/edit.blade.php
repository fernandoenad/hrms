@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Modify User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.users') }}">Users</a></li>
                    <li class="breadcrumb-item active">Modify User</li>
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
                    <form method="POST" action="{{ route('ictu.users.update', $userrole->id) }}">
                        @csrf
                        @method('PATCH')

                        <h5>User Details</h5>
                        <div class="form-group row">
                            <label for="person_name" class="col-md-3 col-form-label text-md-right">{{ __('Fullname') }}</label>

                            <div class="col-md-8">
                                <input readonly id="person_name" type="text" class="form-control @error('person_name') is-invalid @enderror" name="person_name" value="{{ old('person_name') ?? $userrole->user->name }}" autocomplete="person_name">
                                
                                @error('person_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-8">
                                <input readonly id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $userrole->user->email }}" autocomplete="email">
                                
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
                                <input readonly id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') ?? $userrole->user->username }}" autocomplete="username">
                                
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="role_id" class="col-md-3 col-form-label text-md-right">{{ __('Role') }}</label>

                            <div class="col-md-8">
                                <select id="role_id" type="text" class="form-control @error('role_id') is-invalid @enderror" name="role_id" value="{{ old('role_id') ?? $userrole->user->role_id}}" autocomplete="role_id">
                                    <option value="">Select</option>
                                    @for($i=2; $i<=3; $i++)
                                        <option value="{{ $i }}" @if(old('role_id') == $i || $userrole->role_id == $i) {{ 'selected' }} @endif>{{ $userrole->getRole($i) }}</option>
                                    @endfor
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
                                        {{ __('Update User') }}
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
            @include('ictu.users._tools')
        </div>        
    </div>
</div>
@endsection

