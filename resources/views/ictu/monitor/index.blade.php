@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Monitor Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item active">Monitor Users</li>
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
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">All</span>
                            <span class="info-box-number">
                                <a href="#">
                                    {{ number_format(App\Models\User::count(), 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Online</span>
                            <span class="info-box-number">
                                <a href="#">
                                    {{ number_format($users->count(), 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                
            </div>

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
                    Active Users
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Email</th>
                                    <th width="45%">Name</th>
                                    <th width="25%">Online Since</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @if(sizeof($users) > 0)
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>
                                            @php $person = App\Models\Person::find($user['person_id']); @endphp
                                            {{ isset($person) ? $person->getFullnameSorted() : '' }} <br>
                                            {{ isset($person) ? $person->employee->item->station->name : '' }} 
                                            ({{ isset($person) ? $person->employee->item->station->code : '' }})

                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($user['online_since'])->diffForHumans() }}</td>
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
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ictu.monitor._tools')
        </div>
    </div>
</div>
@endsection
