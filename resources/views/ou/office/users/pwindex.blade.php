@extends('layouts.ouof')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">{{ $office->name ?? '' }}</a></li>
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
                                    <th>Email</th>                                  
                                    <th>Action</th>
                                </tr>
                            </thead>
                                
                            <tbody>
                                @if(sizeof($users) > 0)
                                    @foreach($users as $user)
                                        <tr>
                                            <td><img src="{{ asset('storage/avatars') }}/{{ $user->person->image }}" width="40" class="img-circle"></td>
                                            <td>{{ $user->person->getFullnameSorted() }}</td>
                                            <td>{{ $user->person->user->email }}</td>
                                            <td>
                                                <a href="{{ route('ou.office.pw.reset', [$office, $user]) }}" 
                                                    onclick="return confirm('This will reset the password of {{ $user->name }} to Password@123. Are you sure?')"
                                                    class="btn btn-sm btn-primary" title="Reset password">
                                                    <span class="fas fa-fw fa-key"></span>
                                                </a>
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
            @include('ou.office.users._tools')
        </div>        
    </div>
</div>
@endsection

