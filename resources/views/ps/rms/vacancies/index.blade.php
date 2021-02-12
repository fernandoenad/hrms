@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Vacancies</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms') }}">RMS Dashboard</a></li>
                    <li class="breadcrumb-item">Vacancies</li>
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
                <div class="card-header">
                    Vacancy List
                    <span class="float-right">
                        <a href="{{ route('ps.rms.vacancies-create') }}" class="btn btn-primary btn-sm">New Vacancy</a>
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th class="text-right">Salary Grade</th>  
                                    <th>Vacancy Level</th>  
                                    <th>Curricular Level</th>  
                                    <th class="text-right">Vacancy</th>  
                                    <th>Status</th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($vacancies) > 0)
                                    @foreach($vacancies as $vacancy)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ps.rms.vacancies-show', $vacancy->id) }}">
                                                    <strong>{{ $vacancy->name ?? '' }}</strong>
                                                </a>
                                            </td>
                                            <td class="text-right">{{ $vacancy->salarygrade ?? '' }}</td>
                                            <td>{{ $vacancy->getvacancylevel($vacancy->vacancylevel) ?? '' }}</td>
                                            <td>{{ $vacancy->curricularlevel ?? '' }}</td>
                                            <td class="text-right">{{ $vacancy->vacancy ?? '' }} slot(s)</td>
                                            <td>
                                                <span class="badge badge-{{ $vacancy->getstatuscolor($vacancy->status) ?? '' }}">
                                                    {{ $vacancy->getstatus($vacancy->status) ?? '' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="6">No record found.</td></tr>
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
