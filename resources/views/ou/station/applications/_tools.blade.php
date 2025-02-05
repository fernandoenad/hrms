<div class="card card-info">
    <div class="card-header">Navigation</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('ou.station.applications' , $station->id) }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Applications
                </a>
            </li>
            @if(Route::currentRouteName() == 'ou.station.applications.assess.index' ||
                Route::currentRouteName() == 'ou.station.applications.assess.update' || 
                Route::currentRouteName() == 'ou.station.applications.edit' ||
                Route::currentRouteName() == 'ou.station.applications.show')
            <li class="nav-item">
                <a href="{{ route('ou.station.applications.showvacancy', [$station->id, $cycle, $vacancy]) }}" 
                    class="nav-link">
                    <i class="fas fa-reply"></i> Back to position
                </a>
            </li>
            @endif
            @if(Route::currentRouteName() == 'ou.station.applications.showcycle' ||
                Route::currentRouteName() == 'ou.station.applications.takein' ||
                Route::currentRouteName() == 'ou.station.applications.showvacancy' ||
                Route::currentRouteName() == 'ou.station.applications.showresult')
            <li class="nav-item">
                <a href="{{ route('ou.station.applications.takein' , [$station, $cycle]) }}" class="nav-link">
                    <i class="fas fa-search"></i> Search application
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.station.applications.takein' , [$station, $cycle]) }}" class="nav-link">
                    <i class="fas fa-share"></i> Take-in application
                </a>
            </li>
            @endif

            @if(Route::currentRouteName() == 'ou.station.applications.showvacancy')
            <li class="nav-item">
                <a href="{{ route('ou.station.applications.showvacancy.ieraview' , [$station, $cycle, $vacancy]) }}" 
                    target="_blank" class="nav-link">
                    <i class="fas fa-inbox"></i> Print IER-A Sheet
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.station.applications.showvacancy.iesview' , [$station, $cycle, $vacancy]) }}" 
                    target="_blank" class="nav-link">
                    <i class="fas fa-inbox"></i> Print IES
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ou.station.applications.showvacancy.ierbview' , [$station, $cycle, $vacancy]) }}" 
                    target="_blank" class="nav-link">
                    <i class="fas fa-inbox"></i> Print IER-B Sheet
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
                    1) Initial Evaluation
                </a>
            </li>
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    2) Tag application status with either Qualified (star) or Disqualified (bin). 
                </a>
            </li>
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    3) Print the EIR Sheet B and post to the School's communication channels.
                </a>
            </li>
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    4) Face-to-Face Pertinent Document Appreciation
                </a>
            </li>
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    5) Print the EIR Sheet A and together all IES and applicant folders, submit to the District Office for the next phase.
                </a>
            </li>
        </ul>
    </div>
    
</div>