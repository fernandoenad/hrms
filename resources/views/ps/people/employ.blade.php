@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Employ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.people') }}">People</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.people.show', $person->id) }}">Person</a></li>
                    <li class="breadcrumb-item active">Employ</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('ps.people._profile')
        </div>

        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h5>{{ __('Confirm Employment')}}</h5>
                </div>

                <div class="card-body">
                    <p>
                        
                    </p>
                </div>

                <div class="card-footer">
                    <a href="{{ route('ps.people.resetdone', $person->id) }}" class="btn btn-primary float-right">
                        {{ __('Employ') }}
                    </button>
                    <a href="{{ route('ps.people.show', $person->id) }}" class="btn btn-default">
                        {{ __('Cancel') }}
                    </a>
                </div>  
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.people._tools')
        </div>
    </div>
</div>
@endsection
