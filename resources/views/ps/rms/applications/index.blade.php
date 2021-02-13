@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applications By Cycle</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms') }}">RMS</a></li>
                    <li class="breadcrumb-item">Applications By Cycle</li>
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
                                    <th>Cycle</th>
                                    <th class="text-right">Positions</th> 
                                    <th class="text-right">Applications</th>
                                    <th class="text-right">New</th>
                                    <th class="text-right">Pending</th>
                                    <th class="text-right">Confirmed</th>                                     
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($cycles) > 0)
                                    @foreach($cycles as $cycle)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ps.rms.applications-show-cycle', $cycle->schoolyear) }}">
                                                    <strong>{{ $cycle->schoolyear ?? '' }} Cycle</strong>
                                                </a>
                                            </td>
                                            <td class="text-right">{{ App\Models\Application::where('schoolyear', '=', $cycle->schoolyear)
                                                    ->groupBy('vacancy_id')
                                                    ->select('vacancy_id')->get()->count() }}</td>
                                            <td class="text-right">{{ App\Models\Application::where('schoolyear', '=', $cycle->schoolyear)->count() }}</td>
                                            <td class="text-right">{{ App\Models\Application::where('schoolyear', '=', $cycle->schoolyear)
                                                    ->where('status', '=', 1)->get()->count() }}</td>
                                            <td class="text-right">{{ App\Models\Application::where('schoolyear', '=', $cycle->schoolyear)
                                                    ->where('status', '=', 2)->get()->count() }}</td>
                                            <td class="text-right">{{ App\Models\Application::where('schoolyear', '=', $cycle->schoolyear)
                                                    ->where('status', '=', 3)->get()->count() }}</td>
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
