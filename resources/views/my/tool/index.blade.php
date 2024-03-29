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
                                    <img src="{{ asset('storage/avatars/' . $person->image) }}" class="img-circle" style="width: 50px"> 
                                    <a href="{{ route('my.tools.image-edit') }}" title="Click to update image.">Change</a>
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

