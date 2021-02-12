@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $cycle ?? '' }} Applications</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms') }}">RMS</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms.applications') }}">All</a></li>
                    <li class="breadcrumb-item">{{ $cycle ?? '' }} Applications</li>
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
            <div class="card card-primary card-outline">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>Positions</th>
                                    <th>Vacancies</th> 
                                    <th>Applications</th>
                                    <th>New</th>
                                    <th>Pending</th>
                                    <th>Confirmed</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($vacancies) > 0)
                                    @foreach($vacancies as $vacancy)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ps.rms.applications-show-vacancy', [$cycle, $vacancy->id]) }}">
                                                    <strong>{{ $vacancy->name ?? '' }}</strong>
                                                </a>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="6"></td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.rms._tools')
        </div>
    </div>
</div>
@endsection
