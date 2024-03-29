@extends('layouts.ouof')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applications for the {{ $cycle }} Cycle</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">{{ $office->name ?? '' }}</a></li>
                    <li class="breadcrumb-item active">Applications</li>
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
            
            <div class="card card-outline card-primary">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Applicant</th>
                                    <th>Position applied for</th>                                  
                                    <th>Station</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                
                            <tbody>
                                @if(sizeof($applications) > 0)
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $application->last_name }}, {{ $application->first_name }}</td>
                                            @php 
                                                $vacancy =  App\Models\Vacancy2::find($application->vacancy_id);
                                            @endphp 
                                            <td>{{ $vacancy->position_title }} ({{ $vacancy->cycle }})</td>
                                            @php 
                                                $station =  App\Models\Station::find($application->station_id);
                                            @endphp 
                                            <td>{{ $station->code }}- {{ $station->name }}</td>
                                            @php 
                                                $assessment =  App\Models\Assessment::where('application_id', '=', $application->id)->get();
                                            @endphp 
                                            <td>{{ $assessment->count() == 0 ? 'New' :  ($assessment->first()->status == 1 ? 'Pending' : 'Completed') }}</td>
                                            <td>
                                                <a href="{{ route('ou.office.applications.umprocess', [$office, $cycle, $application->id]) }}" 
                                                    onclick="return confirm('This will revert completed status to PENDING status, particulary useful when modifying assessment after Mark Complete was executed. Are you sure?')"
                                                    class="btn btn-sm btn-warning {{ $assessment->first()->status < 2 ? 'disabled' : '' }} " 
                                                    title="Revert to Pending">
                                                    <span class="fas fa-sign-out-alt fa-fw"></span> Revert to Pending
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No record was found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ou.office.applications._tools')
        </div>        
    </div>
</div>
@endsection

