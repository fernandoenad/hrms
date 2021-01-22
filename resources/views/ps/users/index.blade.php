@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Managers</span>
                            <span class="info-box-number">
                                {{ number_format($manager_count, 0) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Users</span>
                            <span class="info-box-number">
                                {{ number_format($user_count, 0) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card card-outline card-primary">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th width="8%">&nbsp;</th>
                                    <th>Fullname</th>
                                    <th>Username</th>                                    
                                    <th>Role</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                                
                            <tbody>
                                @if(sizeof($user_roles) > 0)
                                    @foreach($user_roles as $user_role)
                                        <tr>
                                            <td><img src="{{ url('/') }}/storage/avatars/{{ $user_role->user->person->image }}" width="40" class="img-circle"></td>
                                            <td>
                                                <a href="{{ route('ps.users.show', $user_role->id ) }}">
                                                    {{ $user_role->user->name }}
                                                </a>
                                            </td>
                                            <td>{{ $user_role->user->username }}</td>
                                            <td>{{ $user_role->getRole($user_role->role_id) }}</td>
                                            <td>{{ $user_role->getStatus($user_role->status) }} </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No record was found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.users._tools')
        </div>        
    </div>
</div>
@endsection

