@extends('layouts.app')

@section('content')    
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Request Lookup</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('help') }}">Home</a></li>
                    <li class="breadcrumb-item active">Request Lookup</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                        @if (session('status'))
                            {{ session('status') }}
                        @else
                            {{ 'Request Lookup' }}
                        @endif
                        <a href="{{ route('help.reset') }}" class="btn btn-primary btn-sm float-right">New Password Reset Request</a>
                    </div>
                
                    <div class="card-body pt-3">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="lead"><b>
                                    @if (session('status'))
                                        {{ __('Tracking number is not found, please check the number and try again.') }}
                                    @else
                                        {{ 'Input the tracking number on the search box found on the right side-bar to begin.' }}
                                    @endif
                                </b></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('home.requests._tools')
            </div>
        </div>
    </div>
</div>
@endsection