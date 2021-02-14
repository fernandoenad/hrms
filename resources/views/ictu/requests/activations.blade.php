@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Recent Activations</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.requests') }}">Requests Management</a></li>
                    <li class="breadcrumb-item active">Recent Activations</li>
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

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card card-outline card-primary">
                <div class="card-header">
                    Recent Activations
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Timestamp</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($users) > 0)
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ date('M d, Y h:ia', strtotime($user->email_verified_at)) ?? '' }}</td>
                                            <td>{{ $user->name ?? '' }}</td>
                                            <td>{{ $user->username ?? '' }}</td>
                                            <td>{{ $user->email ?? '' }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">{{ __('No record was found.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix p-2 pb-0">
                    <div class="float-right small">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ictu.requests._tools')
        </div>
    </div>
</div>
@endsection
