@extends('layouts.dpsu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Lookup Employee</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dpsu') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dpsu.users') }}">Users</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dpsu.users.create') }}">New User</a></li>
                    <li class="breadcrumb-item active">Lookup Employee</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-primary">
                <div class="card-header pr-3">
                    <div class="float-right">
                        <form class="form-inline" method="post" action="{{ route('dpsu.users.lookup') }}">
                            @csrf

                            <div class="input-group input-group-md float-right">
                                <input id="searchString" name="searchString" class="form-control form-control-navbar" value="{{ request()->searchString }}" autocomplete="searchString" type="search" placeholder="Search employee" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Employee No.</th>
                                    <th>Employee Name</th>
                                    <th>Position</th>
                                    <th>Station</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($employees) > 0)
                                    @foreach($employees as $employee)
                                        <tr>
                                            <td>{{ $employee->empno }}</td>
                                            <td>
                                                <a href="{{ route('dpsu.users.create')}}?id={{ $employee->person->user->id }}&name={{ $employee->person->getFullnameBox() }}">
                                                    <strong>{{ $employee->person->getFullnameSorted() }}</strong>
                                                </a>
                                            </td>
                                            <td>{{ $employee->item->position }}</td>
                                            <td>
                                                {{ $employee->item->deployment->station->name ?? __('') }}
                                                ({{ $employee->item->deployment->station->code ?? __('') }})
                                            </td>                                    
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">
                                            {{ __('No record was found.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        {!! $employees->render() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            @include('dpsu.users._tools')
        </div>        
    </div>
</div>
@endsection

