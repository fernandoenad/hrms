@extends('layouts.ouof')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Assess Application</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office) }}">{{ $office->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.applications.index', [$office, $cycle]) }}">Vacancies</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.applications.show', [$office, $cycle, $vacancy]) }}">Applications</a></li>
                    <li class="breadcrumb-item active">Assess Application</li>
                    
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">         
            <div class="col-md-9">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                        Application #<strong>{{ $application->id  }}</strong>
                    </div>

                    <form method="post" action="{{ route('ou.office.applications.update', [$office, $cycle, $vacancy, $application]) }}">
                        @csrf 
                        @method('put')
                    <div class="card-body p-0">
                        <table class="table m-0 table-hover">
                            <tbody>
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $application->getFullname() }}</td>
                                </tr>
                                <tr>
                                    <th>Position title applied for</th>
                                    <td>{{ $application->vacancy->position_title }}</td>
                                </tr>
                                @php 
                                    $assessment = App\Models\Assessment::where('application_id', '=', $application->id)->first();

                                @endphp
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $assessment->status == 2 ? 'Pending' : 'Completed' }}</td>
                                </tr>
                                @php 
                                    $assessment_scores = json_decode($assessment->assessment);
                                    $template = App\Models\Template::find($vacancy->template_id);
                                    $assessment_template = json_decode($template->template, true);
                                    $total_points = 0;
                                @endphp 

                                @foreach($assessment_scores as $key => $value)
                                    @php $total_points += is_numeric($value) ? $value : 0; @endphp
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <td>
                                            <div class="form-group">
                                                <input type="{{ is_numeric($value) ? 'number' : 'text' }}" class="form-control" placeholder="Enter {{$key}} points" 
                                                    name="{{ $key }}" class="@error('{{ $key }}') is-invalid @enderror"
                                                    max="{{ $assessment_template[$key] }}"
                                                    step="{{ is_numeric($value) ? '0.001' : '' }}"
                                                    {{ $assessment->status > 2 ? 'readonly' : (str_contains($key,'*') ? 'readonly' : '' ) }}
                                                    value="{{ $value }}">
                                                @error($key)
                                                    <span class="text-danger"><small>{{ $message }}</small></span>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>
                                    
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-right text-danger">* is to be inputted by the SDO.</td>
                                </tr>
                            </tbody>
                        </table>                    
                    </div>

                    <div class="card-footer p-2">
                        <button type="submit" class="btn btn-warning {{ $assessment->status == 3 ? 'disabled' :'' }}">Update</button>
                        <a href="{{ route('ou.office.applications.mark', [$office, $cycle, $vacancy, $application, $total_points]) }}" 
                            onclick="return confirm('Please hit the Modify button first before hitting the Mark Complete button. This will mark the assessment as complete and non-modifiable. You can revert this action via the Applications page. Are you sure?')"
                            class="btn btn-primary {{ $assessment->status == 3 ? 'disabled' :'' }}">Mark Complete</a>
                        <div class="float-right">
                            <a href="{{ route('ou.office.applications.show', [$office, $cycle, $vacancy]) }}"
                            class="btn btn-info"><i class="fas fa-reply"></i> Back</a>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-3">
                @include('ou.office.applications._tools')
            </div>
        </div>
    </div>
</div>
@endsection