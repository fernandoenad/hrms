@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Role</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.roles') }}">Roles</a></li>
                    <li class="breadcrumb-item active">Role</li>
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
            <div class="row justify-content-center">
                @if(Route::currentRouteName() == 'ictu.roles.confirm-delete')
                    <div class="col-md-8">
                        <div class="card card-default">
                            <div class="card-header">
                                <h5>Confirm User Removal</h5>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('ictu.roles.delete', $userrole->id ) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')

                                    <p>
                                        This action removes access for <strong>{{ $userrole->user->username }}</strong>
                                        from the Roles portal.
                                    </p>
                                
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary float-right">
                                                {{ __('Remove User') }}
                                            </button>
                                            <a href="{{ url()->previous() }}" class="btn btn-default">
                                                {{ __('Cancel') }}
                                            </a>
                                        </div>
                                    </div> 
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                    {{ $userrole->getRole($userrole->role_id) }}
                </div>

                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-7">
                            <p></p>
                            <h2 class="lead"><b> {{ $userrole->user->name }}</b></h2>
                            <p class="text-muted text-sm"> 
                                @if(isset($userrole->user->person->employee))
                                    {{ $userrole->user->person->employee->item->position }}
                                @endif
                            </p>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-user"></i></span> Username: {{ $userrole->user->username }} </li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Email: {{ $userrole->user->email }}</li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{ $userrole->user->person->contact->primaryno }} </li>
                            </ul>
                        </div>
                        <div class="col-5 text-right">
                            <p></p>
                            <img src="{{ url('/') }}/storage/avatars/{{ $userrole->user->person->image }}" alt="" class="img-circle img-fluid w-50">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        @if(isset($userrole->user->person->employee))
                            <a href="{{ route('ictu.employees.show', $userrole->user->person->employee->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-user"></i> View Employee Profile
                            </a>
                        @endif  
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ictu.roles._tools')
        </div>        
    </div>
</div>
@endsection

