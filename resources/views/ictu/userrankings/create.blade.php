@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Ranking User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.userranking') }}">Ranking User</a></li>
                    <li class="breadcrumb-item active">New Ranking User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-body">
                    <form method="POST" action="{{ route('ictu.userranking.store') }}">
                        @csrf

                        <h5>User Details</h5>
                        <div class="form-group row">
                            <label for="user_id" class="col-md-3 col-form-label text-md-right">{{ __('Assessor') }}</label>

                            <div class="col-md-8">
                                <input readonly id="user_id" type="hidden" class="form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id') ?? request()->id }}" autocomplete="user_id">
                                <div class="input-group input-group-md">
                                    <input readonly id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? request()->name }}" autocomplete="name">
                                
                                    <div class="input-group-append">
                                        <a href="{{ route('ictu.userranking.lookup') }}" class="btn btn-primary float-right">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </div>
                                </div>

                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vacancy_id" class="col-md-3 col-form-label text-md-right">{{ __('Assignment') }}</label>

                            <div class="col-md-8">
                                <select id="vacancy_id" type="text" class="form-control @error('vacancy_id') is-invalid @enderror" name="vacancy_id" autocomplete="vacancy_id">
                                    <option value="">Select</option>
                                    @foreach($vacancies as $vacancy)
                                        <option value="{{ $vacancy->id ?? '' }}" @if(old('vacancy_id') == $vacancy->id) {{ 'selected' }} @endif>{{ $vacancy->name ?? ''}}</option>
                                    @endforeach
                                </select>

                                @error('vacancy_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{ __('Save User') }}
                                    </button>
                                    <a href="{{ url()->previous()}}" class="btn btn-default">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            @include('ictu.userrankings._tools')
        </div>        
    </div>
</div>
@endsection

