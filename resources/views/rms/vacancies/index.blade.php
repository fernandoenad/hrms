@extends('layouts.my')  

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">My Assignments</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('rms') }}">Home</a></li>
                    <li class="breadcrumb-item active">My Assignments</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">              
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        Vacancy List
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0 table-hover ">
                                <thead>
                                    <tr>
                                        <th>Position</th>
                                        <th>Vacancy Level</th>  
                                        <th>Curricular Level</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                @if(sizeof($vacancies) > 0)
                                    @foreach($vacancies as $vacancy)
                                        <tr>
                                            <td>
                                                <a href="{{ route('rms.vacancy.show', $vacancy->id) }}">
                                                    <strong>{{ $vacancy->name ?? '' }}</strong>
                                                </a>
                                            </td>
                                            <td>{{ $vacancy->getvacancylevel($vacancy->vacancylevel) ?? '' }}</td>
                                            <td>{{ $vacancy->curricularlevel ?? '' }}</td>
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
                @include('rms.vacancies._tools')
            </div>
        </div>
    </div>
</div>
@endsection