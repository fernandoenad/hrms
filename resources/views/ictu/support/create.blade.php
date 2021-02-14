@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Article</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.support') }}">Support Mgmt</a></li>
                    <li class="breadcrumb-item active">New Article</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    New Support Article
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('ictu.support.store') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="title" class="col-md-2 col-form-label text-md-right">{{ __('Title') }}</label>

                        <div class="col-md-9">
                            <input readonly id="type" type="hidden" class="form-control @error('type') is-invalid @enderror" name="type" value="Help" autocomplete="type">
                            <input id="type" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autocomplete="title">

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="content" class="col-md-2 col-form-label text-md-right">{{ __('Content') }}</label>

                        <div class="col-md-9">
                            <textarea id="mytextarea-post" class="form-control @error('content') is-invalid @enderror" name="content" value="" autocomplete="content">{{ old('content') }}</textarea>

                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Save Post') }}
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-default">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right small">
                    
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ictu.support._tools')
        </div>
    </div>
</div>
@endsection
