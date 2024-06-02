@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Take In Application for {{ $cycle }} Cycle</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications', $station->id) }}">Cycles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications.showcycle', [$station, $cycle]) }}">{{ $cycle }} Applications</a></li>
                    <li class="breadcrumb-item active">Take In Application</li>
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

            <div class="card card-primary p-0">
                <div class="card-header">
                    Take In Application
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('ou.station.applications.showresult', [$station, $cycle]) }} ">
                    @csrf
                    @method('post')
                    <div class="input-group input-group-lg">
                        <input type="text" name="application_code" class="form-control" placeholder="Enter application code..." value="{{ $search ?? '' }}">
                        <span class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                        </span>
                    </div>
                    @error('application_code')
                        <span class="text-danger"><small>{{ $message }}</small></span>
                    @enderror
                    </form>
                </div>
            </div>

            <div class="card card-primary card-outline">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th width="20%">Application code</th>
                                    <th>Applicant</th>
                                    <th>Position applied for</th>
                                    <th width="20%">Station applied for</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($applications) > 0)
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $application->application_code }}</td>
                                            <td>{{ $application->getFullname() }}</td>
                                            <td>{{ $application->position_title }}</td>
                                            @php 
                                                $school_info = App\Models\Station::find($application->station_id);
                                            @endphp
                                            <td>{{ $school_info == null ? 'Not yet assigned' : $school_info->code . '-' . $school_info->name; }}</td>
                                            <td>
                                                <form method="post" action="{{ route('ou.station.applications.takeinok', [$station, $cycle, $application]) }}">
                                                    @csrf
                                                    @method('post')
                                                    <button href="" 
                                                        class="btn btn-sm btn-primary" title="Take in"
                                                        onclick="return confirm('This will take in the selected application. Are you sure?')"
                                                        {{ $school_info != null ? 'disabled' : '' }}>
                                                        <span class="fas primary fa-fw fa-inbox"></span> Take In
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach 
                                    <tr><td colspan="5">
                                        <em>Listing is 5 records only and for disabled Take In buttons, the current station must withdraw the application first from their end. </em>                                        
                                    </td></tr>
                                @else 
                                    <tr><td colspan="5"><em>0 applications found. Input the application code on the search field to take in new applications.</em></td></tr>
                                @endif 
                            </tbody>
                        </table>

                    </div>
                </div> 
            </div>
            
        </div>

        <div class="col-md-3">
            @include('ou.station.applications._tools')
        </div>
    </div>
</div>
@endsection
