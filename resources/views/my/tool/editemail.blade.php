@extends('layouts.my')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Tools')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('my') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('my.tools') }}">My Tools</a></li>
                    <li class="breadcrumb-item active">Modify E-Mail</li>
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
                    <h4>Account Information</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="20%">Field</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $person->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $person->user->username }}</td>
                            </tr>
                            <tr>
                                <th>E-Mail</th>
                                <td>
                                    <form method="POST" action="{{ route('my.tools.email-update') }}">
                                        @csrf
                                        @method('PATCH')

                                        <div class="col-md-8">
                                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $person->user->email }}" autocomplete="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <br>
                                            <a href="{{ route('my.tools') }}" class="btn btn-default">
                                                {{ __('Cancel') }}
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Update Email') }}
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td><a href="{{ route('my.tools.password-edit') }}" title="click to update password">********</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

