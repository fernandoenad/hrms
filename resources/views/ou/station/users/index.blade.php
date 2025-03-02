@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }}</a></li>
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
                                    <th></th>
                                </tr>
                            </thead>
                                
                            <tbody>
                                @if(sizeof($usersts) > 0)
                                    @foreach($usersts as $userst)
                                        <tr>
                                            <td><img src="{{ asset('storage/avatars') }}/{{ $userst->user->person->image }}" width="40" class="img-circle"></td>
                                            <td>{{ $userst->user->person->getFullnameSorted() }}</td>
                                            <td>{{ $userst->user->email }}</td>
                                            <td>User</td>
                                            <td class="text-right">
                                                <form method="POST" action="{{ route('ou.station.users.destroy', [$station->id, $userst->id]) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-sm btn-danger 
                                                        @if(Auth::user()->getStations()->first()) 
                                                            {{ '' }} 
                                                        @elif(Auth::user()->getOffices()->first()) 
                                                            {{ '' }} 
                                                        @else
                                                            {{ '' }} 
                                                        @endif"
                                                        onClick="return confirm('This will remove the user access which is IRREVERSIBLE. \nAre you sure wish to proceed?')">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
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
            @include('ou.station.users._tools')
        </div>        
    </div>
</div>
@endsection

