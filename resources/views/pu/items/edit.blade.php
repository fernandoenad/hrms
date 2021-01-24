@extends('layouts.pu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Modify Item</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.items') }}">Items</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.items.show', $item->id) }}">Item</a></li>
                    <li class="breadcrumb-item active">Modify Item</li>
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
            <div class="card card-primary">
                <div class="card-body">
                    <form method="POST" action="{{ route('pu.items.update', $item->id) }}">
                        @csrf
                        @method('PATCH')

                        <h5>Item Information</h5>
                        <div class="form-group row">
                            <label for="itemno" class="col-md-3 col-form-label text-md-right">{{ __('Item No.') }}</label>

                            <div class="col-md-8">
                                <input readonly id="itemno" type="text" class="form-control @error('itemno') is-invalid @enderror" name="itemno" value="{{ old('itemno') ?? $item->itemno }}" autocomplete="itemno">

                                @error('itemno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="creationdate" class="col-md-3 col-form-label text-md-right">{{ __('Creation Date') }}</label>

                            <div class="col-md-8">
                                <input readonly id="creationdate" type="date" class="form-control @error('creationdate') is-invalid @enderror" name="creationdate" value="{{ old('creationdate') ?? date('Y-m-d', strtotime($item->creationdate)) }}" autocomplete="creationdate">

                                @error('creationdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-3 col-form-label text-md-right">{{ __('Position') }}</label>

                            <div class="col-md-8">
                                <input readonly list="positions" id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') ?? $item->position }}" autocomplete="position">
                                <datalist id="positions">
                                    @foreach($positions as $position)
                                        <option value="{{ $position->position }}">
                                    @endforeach
                                </datalist>

                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="salarygrade" class="col-md-3 col-form-label text-md-right">{{ __('Salary Grade') }}</label>

                            <div class="col-md-8">
                                <input readonly id="salarygrade" type="text" class="form-control @error('salarygrade') is-invalid @enderror" name="salarygrade" value="{{ old('salarygrade') ?? $item->salarygrade }}" autocomplete="salarygrade">

                                @error('salarygrade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="employeetype" class="col-md-3 col-form-label text-md-right">{{ __('Employee Type') }}</label>

                            <div class="col-md-8">
                                <input readonly id="employeetype" type="text" class="form-control @error('employeetype') is-invalid @enderror" name="employeetype" value="{{ old('employeetype') ?? $item->employeetype }}" autocomplete="employeetype">

                                @error('employeetype')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="station_id" class="col-md-3 col-form-label text-md-right">{{ __('Plantilla Owner') }}</label>

                            <div class="col-md-8">
                                <select id="station_id" type="text" class="form-control @error('station_id') is-invalid @enderror" name="station_id" value="{{ old('station_id') }}" autocomplete="station_id">
                                    <option value="">Select</option>
                                    <option value="0" @if (old('station_id') == 0 ) {{ 'selected' }} @endif>TBA</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}" @if (old('station_id') == $station->id  || $item->station_id == $station->id ) {{ 'selected' }} @endif>{{ $station->code }} - {{ $station->name }}, {{ $station->office->name }}</option>
                                    @endforeach
                                </select>

                                @error('station_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deployment_station_id" class="col-md-3 col-form-label text-md-right">{{ __('Deployment') }}</label>

                            <div class="col-md-8">
                                <select id="deployment_station_id" type="text" class="form-control @error('deployment_station_id') is-invalid @enderror" name="deployment_station_id" value="{{ old('deployment_station_id') }}" autocomplete="deployment_station_id">
                                    <option value="">Select</option>
                                    <option value="0" @if (old('deployment_station_id') == 0 ) {{ 'selected' }} @endif>TBA</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}" @if (old('deployment_station_id') == $station->id || $item->deployment->station_id == $station->id ) {{ 'selected' }} @endif>{{ $station->code }} - {{ $station->name }}, {{ $station->office->name }}</option>
                                    @endforeach
                                </select>

                                @error('deployment_station_id')
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
                                        {{ __('Update Item') }}
                                    </button>
                                    <a href="{{ url()->previous() }}" class="btn btn-default">
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
            @include('pu.items._tools')
        </div>
    </div>
</div>
@endsection
