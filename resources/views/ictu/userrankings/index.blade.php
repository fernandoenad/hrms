@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Ranking Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item active">Ranking Users</li>
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
                                    <th>Assignment</th>                                   
                                    <th width="15%"></th>
                                </tr>
                            </thead>
                                
                            <tbody>
                                @if(sizeof($userrankings) > 0)
                                    @foreach($userrankings as $userranking)
                                        <tr>
                                            <td><img src="{{ asset('storage/avatars') }}/{{ $userranking->user->person->image }}" width="40" class="img-circle"></td>
                                            <td>{{ $userranking->user->name }}</td>
                                            <td>{{ $userranking->user->username }}</td>
                                            <td>{{ $userranking->vacancy->name }}</td>
                                            <td class="text-right">
                                                <form method="POST" action="{{ route('ictu.userranking.destroy', $userranking->id) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-sm btn-danger" 
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
            @include('ictu.userrankings._tools')
        </div>        
    </div>
</div>
@endsection

