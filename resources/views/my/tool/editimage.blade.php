@extends('layouts.my')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">My Tools</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('rms') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('my') }}">My Profile</a></li>
                    <li class="breadcrumb-item active">My Tools</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('my._profile')
        </div>
        
        <div class="col-md-9">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
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
                                <td><a href="{{ route('my.tools.email-edit') }}" title="Click to update email.">{{ $person->user->email }}</a></td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td><a href="{{ route('my.tools.password-edit') }}" title="Click to update password.">********</a></td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td>
                                    <form method="POST" action="{{ route('my.tools.image-update') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')

                                        <div class="col-md-8">
                                            <input id="image" type="file" class="form-control-file  @error('image') is-invalid @enderror" name="image" autocomplete="image">

                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <br>
                                            <a href="{{ route('my.tools') }}" class="btn btn-default">
                                                {{ __('Cancel') }}
                                            </a>
                                            <button type="submit" id="image-submit" class="btn btn-primary">
                                                {{ __('Update Image') }}
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

<div class="modal fade" id="progress-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content bg-default">
            <div class="modal-body">
                <strong class="text-center">Uploading media, please wait...</strong>
            </div>
            
        </div>
    </div>
</div>
@endsection

