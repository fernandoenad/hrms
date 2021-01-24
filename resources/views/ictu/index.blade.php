@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Non Employees</span>
                    <span class="info-box-number">
                        <a href="#">
                            {{ number_format($people_count, 0) }}
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Employees</span>
                    <span class="info-box-number">
                        <a href="#">
                            {{ number_format($employees_count, 0) }}
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users-cog"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">User Roles</span>
                    <span class="info-box-number">
                        <a href="#">
                            {{ number_format($userroles_count, 0) }}
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header pr-3">
                    Recently Created Accounts
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Date Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($people) > 0)
                                    @foreach($people as $person)
                                        <tr>
                                            <td>{{ $person->id }}</td>
                                            <td>
                                                <a href="{{ route('ictu.people.show', $person->id)}}">
                                                    {{ $person->getFullNameSorted() }}
                                                </a>
                                            </td>
                                            <td>   
                                                @if(isset($person->employee))
                                                    {{ __('Employee') }}
                                                @else
                                                    {{ __('Nony Employee') }}
                                                @endif
                                            </td>
                                            <td>{{ $person->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No record was found.</td>
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
    </div>
</div> 
@endsection
