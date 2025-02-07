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
                                    <th width="15%">Remarks</th>
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
                                            <a href="{{ route('ou.office.pw.reset', [$office, $user]) }}" 
                                                onclick="return confirm('This will reset the password of {{ $user->name }} to Password@123. Are you sure?')"
                                                class="btn btn-sm btn-primary 
                                                    @if($user->person->user->isSuperAdmin() == 1)
                                                        disabled
                                                    @elseif(isset($user->item->station_id) && $user->item->station_id == 0)
                                                    @else
                                                        disabled
                                                    @endif" title="Reset password">
                                                <span class="fas fa-fw fa-key"></span>
                                            </a>
                                        </td>
                                        <td>
                                            @if($user->person->user->isSuperAdmin() == 1)
                                                <small class="text-danger">Not enough privilege to perform action. </small>
                                            @elseif(isset($user->item->station_id) && $user->item->station_id == 0)
                                                <small class="text-success">Reset is allowed.</small>
                                            @elseif($user->item->station->office_id == $office->id)
                                                <small class="text-success">Reset is allowed.</small>
                                            @else
                                                <small class="text-danger">User is outside of your District. Move in to any station/unit in your District/Offie first.</small>
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

