@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Modify Application</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications', $station->id) }}">Cycles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications.showcycle', [$station->id, $cycle]) }}">{{ $cycle }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications.showvacancy', [$station->id, $cycle, $vacancy->id]) }}">Applications</a></li>
                    <li class="breadcrumb-item active">Modify Application</li>
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
                    <form method="post" action="{{ route('ou.station.applications.update', [$station, $cycle, $vacancy, $application]) }}">
                        @csrf 
                        @method('put')
                    <div class="card-body p-2">
                        
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="#">First name & Ext name (if any)</label>
                                    <input type="text" class="form-control" placeholder="e.g. Juan Jr." 
                                        name="first_name" class="@error('first_name') is-invalid @enderror"
                                        value="{{ $application->first_name }}" autofocus>
                                    @error('first_name')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="#">Middle name</label>
                                    <input type="text" class="form-control" placeholder="e.g. Luna or '-' if not applicable" 
                                        name="middle_name" class="@error('middle_name') is-invalid @enderror"
                                        value="{{ $application->middle_name }}">
                                    @error('middle_name')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="#">Last name</label>
                                    <input type="text" class="form-control" placeholder="e.g. Dela Cruz" 
                                        name="last_name" class="@error('last_name') is-invalid @enderror"
                                        value="{{ $application->last_name }}">
                                    @error('last_name')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="#">Address: Sitio/Purok</label>
                                    <input type="text" class="form-control" placeholder="e.g. Purok 2" 
                                        name="sitio" class="@error('sitio') is-invalid @enderror"
                                        value="{{ $application->sitio }}">
                                    @error('sitio')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="#">Barangay</label>
                                    <input type="text" class="form-control" placeholder="e.g. Poblacion" 
                                        name="barangay" class="@error('barangay') is-invalid @enderror"
                                        value="{{ $application->barangay }}">
                                    @error('barangay')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="#">Municipality</label>
                                    <select type="text" class="form-control" placeholder="" 
                                        name="municipality" class="@error('municipality') is-invalid @enderror"
                                        value="{{ $application->municipality }}">
                                            <option value="">---please select---</option>
                                        @foreach($towns as $town)
                                            <option value="{{$town->name}}" {{ $application->municipality == $town->name ? "selected":"" }}>{{$town->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('municipality')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="#">Zip code</label>
                                    <input type="number" class="form-control" placeholder="e.g. 6331" 
                                        name="zip" class="@error('zip') is-invalid @enderror"
                                        value="{{ $application->zip }}">
                                    @error('zip')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="#">Age</label>
                                    <input type="number" class="form-control" placeholder="18" 
                                        name="age" class="@error('age') is-invalid @enderror"
                                        value="{{ $application->age }}">
                                    @error('age')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="#">Gender</label>
                                    <select type="text" class="form-control" placeholder="" 
                                        name="gender" class="@error('gender') is-invalid @enderror"
                                        value="{{ $application->gender }}">
                                        <option value="">---please select---</option>
                                        @foreach($sexes as $sex)
                                            <option value="{{$sex->details}}" {{ $application->gender == $sex->details ? "selected":"" }}>{{$sex->details}}</option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="#">Civil status</label>
                                    <select type="text" class="form-control" placeholder="" 
                                        name="civil_status" class="@error('civil_status') is-invalid @enderror"
                                        value="{{ $application->civil_status }}">
                                        <option value="">---please select---</option>
                                        @foreach($civilstatuses as $civil_status)
                                            <option value="{{$civil_status->details}}" {{ $application->civil_status == $civil_status->details ? "selected":"" }}>{{$civil_status->details}}</option>
                                        @endforeach
                                    </select>
                                    @error('civil_status')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="#">Religion</label>
                                    <input type="text" class="form-control" placeholder="e.g. Christianity or '-' if not applicable" 
                                        name="religion" class="@error('religion') is-invalid @enderror"
                                        value="{{ $application->religion }}">
                                    @error('religion')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="#">Disability</label>
                                    <input type="text" class="form-control" placeholder="e.g. Blind or '-' if not applicable" 
                                        name="disability" class="@error('disability') is-invalid @enderror"
                                        value="{{ $application->disability }}">
                                    @error('disability')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="#">Ethnic group</label>
                                    <input type="text" class="form-control" placeholder="e.g. Eskaya or '-' if not applicable" 
                                        name="ethnic_group" class="@error('ethnic_group') is-invalid @enderror"
                                        value="{{ $application->ethnic_group }}">
                                    @error('ethnic_group')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="#">Email address</label>
                                    <input type="email" class="form-control" placeholder="e.g. username@email.com" 
                                        name="email" class="@error('email') is-invalid @enderror"
                                        value="{{ $application->email }}">
                                    @error('email')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="#">Phone number</label>
                                    <input type="text" class="form-control" placeholder="e.g. 09205001182" 
                                        name="phone" class="@error('phone') is-invalid @enderror"
                                        value="{{ $application->phone }}">
                                    @error('phone')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="#">Position applied for</label>
                                    <select type="text" class="form-control" placeholder="" 
                                        name="vacancy_id" class="@error('vacancy_id') is-invalid @enderror"
                                        value="{{ $application->vacancy_id }}">
                                        <option value="">---please select---</option>
                                        @foreach($vacancies as $vacancy)
                                            <option value="{{$vacancy->id}}" {{ $application->vacancy_id == $vacancy->id ? "selected":"" }}>{{$vacancy->position_title}}</option>
                                        @endforeach
                                    </select>
                                    @error('vacancy_id')
                                        <span class="text-danger"><small>{{ $message }}</small></span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer p-2">
                        <button href="" class="btn btn-primary">Update</button>

                        <div class="float-right">
                            <a href="{{ route('ou.station.applications.showvacancy', [$station->id, $cycle, $vacancy->id]) }}" 
                            class="btn btn-default"><i class="fas fa-reply"></i> Back</a>
                        </div>
                    </div>

                    </form>
                </div>


            </div>

            <div class="col-md-3">
                @include('ou.station.applications._tools')
            </div>
        </div>
    </div>
</div>
@endsection