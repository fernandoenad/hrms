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
                <a href="{{ route('ou.station.applications.showvacancy', [$station->id, $cycle, $vacancy->id]) }}" 
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
                    <i class="fas fa-inbox"></i> Take In Applications
                </a>
            </li>
            @endif

            @if(Route::currentRouteName() == 'ou.station.applications.showvacancy')
            <li class="nav-item">
                <a href="{{ route('ou.station.applications.showvacancy.carview' , [$station, $cycle, $vacancy]) }}" 
                    target="_blank" class="nav-link">
                    <i class="fas fa-inbox"></i> View ICAR Sheet
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
            <li class="nav-item"><a href="https://docs.google.com/presentation/d/1OPwapDlPVi0Z4lAVeF4f2eIYS-CHywICnWrus4vxN3w/edit?usp=sharing" class="nav-link" target="_blank"><strong>Click here for detailed steps</strong></a></li>
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    Remember, there is no inputting of scores in the school level.
                </a>
            </li>
            <li class="nav-item">
                <a href="#" target="_blank" class="nav-link">
                    The goal is to mark all applications as COMPLETED with no scores.
                </a>
            </li>
        </ul>
    </div>
    
</div>