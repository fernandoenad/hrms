@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $filter }} Applications</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms') }}">RMS</a></li>
                    <li class="breadcrumb-item">{{ $filter }} Applications</li>
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
                        <small>
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="25%">Name</th>
                                    <th>Contact</th> 
                                    <th>Address</th> 
                                    <th width="8%">CD</th> 
                                    <th width="15%">Position applied</th>
                                    <th>Appl. No.</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($applications) > 0)
                                    <?php $i=1;?>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <a href="{{ route('ps.rms.applications-show', [$application->schoolyear, $application->vacancy->id,  $application->id]) }}">
                                                    <strong>{{ $application->person->getFullnameSorted() ?? '' }}</strong>
                                                </a>
                                            </td>
                                            <td>
                                                {{ $application->person->contact->primaryno ?? '' }}
                                            </td>
                                            <td>
                                                {{ $application->person->address->current ?? '' }} 
                                            </td>
                                            <td>
                                                CD {{ $application->station->office->town->cdlevel ?? '' }}
                                            </td>
                                            <td>
                                                {{ $application->vacancy->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $application->code ?? '' }}                                         
                                            </td>
                                        </tr>
                                        <?php $i++;?>
                                    @endforeach
                                @else
                                    <tr><td colspan="5">No record found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                        </small>
                    </div>
                </div> 
                <div class="card-footer py-1 ">
                    <?php $count = App\Models\Application::where('schoolyear', '=', $cycle)
                                ->where('type', '=', $filter)->get()->count(); ?>
                    <a href="{{ route('ps.rms.applications-show-showfilter', [$cycle, $filter, $count]) }}" class="btn btn-primary btn-sm">View all</a>
                    <div class="float-right">
                        {!! $applications->render() !!}
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
