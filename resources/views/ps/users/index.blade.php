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
                    <li class="breadcrumb-item active"><a href="{{ route('my') }}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Managers</span>
                            <span class="info-box-number">
                                <a href="">
                                    {{ number_format(0, 0) }}
                                </a>
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
                                <a href="">
                                    {{ number_format(0, 0) }}
                                </a>
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
                                    <th width="25%"></th>
                                </tr>
                            </thead>
                                
                            <tbody>
                                <tr>
                                    <td><img src="/storage/avatars/no-avatar.jpg" width="40" class="img-circle"></td>
                                    <td>Fernando Enad</td>
                                    <td>fernando.enad</td>
                                    <td>Manager</td>
                                    <td>
                                        <a href="" class="btn btn-warning btn-sm">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <a href="" class="btn btn-danger btn-sm">
                                            <i class="fas fa-user-slash"></i>
                                        </a>
                                        <a href="" class="btn btn-success btn-sm">
                                            <i class="fas fa-user-check"></i>
                                        </a>
                                        <a href="" class="btn btn-primary btn-sm">
                                            <i class="fas fa-user-shield"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">No record was found.</td>
                                </tr>
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

