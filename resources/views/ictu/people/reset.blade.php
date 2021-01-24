@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Reset Password</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.people') }}">People</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.people.show', $person->id) }}">Person</a></li>
                    <li class="breadcrumb-item active">Reset Password</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('ictu.people._profile')
        </div>

        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h5>{{ __('Confirm Reset')}}</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ictu.people.update', $person->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <p>
                            This action resets the user's password to its 
                            default value:  <b>{{ $person->user->username }}</b>
                        </p>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Reset Password') }}
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

        <div class="col-md-3">
            @include('ictu.people._tools')
        </div>
    </div>
</div>
@endsection
