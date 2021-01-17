@extends('layouts.my')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Modify Password')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('my') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('my.tools') }}">My Tools</a></li>
                    <li class="breadcrumb-item active">Modify Password</li>
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
                                <td>{{ $person->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td>
                                    <form method="POST" action="{{ route('my.tools.password-update') }}">
                                        @csrf
                                        @method('PATCH')

                                        <div class="col-md-8">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New password" autocomplete="new-password">
                                            <br>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password" autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <br>
                                            <a href="{{ url()->previous() }}" class="btn btn-default">
                                                {{ __('Cancel') }}
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Update Password') }}
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

