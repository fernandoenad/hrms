@if(Route::currentRouteName() == 'ou.office.applications.umindex' || 
    Route::currentRouteName() == 'ou.office.applications.umlookup' || 
    Route::currentRouteName() == 'ou.office.applications.umprocess')
    <div class="card card-info">
        <div class="card-header">{{ __('Search') }}</div>

        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item active p-3">
                    <form class="form-inline" method="post" action="{{ route('ou.office.applications.umlookup', [$office, $cycle]) }}">
                        @csrf
                        @method('post')
                        <div class="input-group input-group-md">
                            <input id="searchString" name="searchString" 
                                class="form-control form-control-navbar @error('searchString') is-invalid @enderror" 
                                value="{{ old('searchString') ?? request()->get('searchString') }}" 
                                autocomplete="searchString" type="search" placeholder="Search last name" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>

@endif 

<div class="card card-info">
    <div class="card-header">Navigation</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('ou.office.applications.index' , $office) }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Applications
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.office.applications.umindex' , [$office, $cycle]) }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Unmark Complete Applications
                </a>
            </li>

            @if(Route::currentRouteName() == 'ou.office.applications.show')
            <li class="nav-item">
                <a href="{{ route('ou.office.applications.carview' , [$office, $cycle, $vacancy]) }}" 
                    target="_blank" class="nav-link">
                    <i class="fas fa-inbox"></i> Print CAR Sheet
                </a>
            </li>
            
            @endif
        </ul>
    </div>
</div>

<div class="card card-info">
    <div class="card-header">Tasks</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    1) Receive bundled submissions (IES, IER-B, Applicants' Folders) from schools. The bundle is per position.
                </a>
            </li>
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    2) Schedule Teaching-Reflection Assessment.
                </a>
            </li>
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    3) Schedule Teaching-Demonstration Assessment.
                </a>
            </li>
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    4) Plugin the scores for each applicant.
                </a>
            </li>
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    5) Print the CAR sheets. Have it signed. Post one copy on the District's communication channels.
                </a>
            </li>
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    6) Submit the signed CAR sheets to SDO-HR.
                </a>
            </li>
        </ul>
    </div>
    
</div>