@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Remove Account</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.people') }}">People</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.people.show', $person->id) }}">Person</a></li>
                    <li class="breadcrumb-item active">Remove Account</li>
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
                    <h5>{{ __('Confirm Account Removal')}}</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ictu.people.destroy', $person->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')

                        <p>
                            This action is IRREVERSIBLE. All associated records will be 
                            deleted and can no longer be retried. Are you sure you wish 
                            to continue?
                        </p>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Continue') }}
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
