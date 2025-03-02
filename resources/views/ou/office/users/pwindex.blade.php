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
                                    <th width="30%">Remarks</th>
                                </tr>
                            </thead>
                                
                            <tbody>
                                @forelse($users as $user)
                                    <!-- $user is actually an employee instance -->
                                    <tr>
                                        <td><img src="{{ asset('storage/avatars') }}/{{ $user->person->image }}" width="40" class="img-circle"></td>
                                        <td>{{ $user->person->getFullnameSorted() }}</td>
                                        <td>{{ $user->person->user->email }}</td>
                                        <td>
                                            <a href="{{ route('ou.office.pw.reset', [$office, $user->person->user]) }}" 
                                                onclick="return confirm('This will reset the password of {{ $user->person->getFullnameSorted() }} to password. Are you sure?')"
                                                class="btn btn-sm btn-primary 
                                                    @if(Auth::user()->id == $user->person->user->id)
                                                        disabled
                                                    @elseif(Auth::user()->isSuperAdmin() == 1)    

                                                    @elseif($user->person->user->isSuperAdmin() == 1)
                                                        disabled
                                                    @elseif(isset($user->item->deployment->station_id) && $user->item->deployment->station_id == 0)

                                                    @elseif(isset($user->item->deployment->station->office_id) &&  $user->item->deployment->station->office_id == $office->id)

                                                    @else
                                                        disabled
                                                    @endif" title="Reset password">
                                                <span class="fas fa-fw fa-key"></span>
                                            </a>
                                        </td>
                                        <td>
                                            @if(Auth::user()->id == $user->person->user->id)
                                            <small class="text-danger">Can't reset yourself here. </small>
                                            @elseif(Auth::user()->isSuperAdmin() == 1)    
                                                <small class="text-success">Reset allowed.</small>
                                            @elseif($user->person->user->isSuperAdmin() == 1)
                                                <small class="text-danger">Low level privilege to perform action.</small>
                                            @elseif(isset($user->item->deployment->station_id) && $user->item->deployment->station_id == 0)
                                                <small class="text-success">Reset allowed.</small>
                                            @elseif(isset($user->item->deployment->station->office_id) &&  $user->item->deployment->station->office_id == $office->id)
                                                <small class="text-success">Reset allowed.</small>
                                            @else
                                                <small class="text-danger">Action not allowed to users outside of District. Deploy/Move-in user to any school within the District. </small>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No record was found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        {!! $users->render() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ou.office.users._tools_pw')
        </div>        
    </div>
</div>
@endsection

