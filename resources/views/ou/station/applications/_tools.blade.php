<div class="card card-info">
    <div class="card-header">Navigation</div>

    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('ou.station.applications' , $station->id) }}" class="nav-link">
                    <i class="fas fa-inbox"></i> Applications
                </a>
            </li>
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
                    <i class="fas fa-inbox"></i> View CAR Sheet
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
            <li class="nav-item"><a href="#" class="nav-link"><strong>New Applications</strong></a></li>
            <li class="nav-item"><a href="#" class="nav-link">1. Take in applications.</a></li>
            <li class="nav-item"><a href="#" class="nav-link">2. Only assess ETE.</a></li>
            <li class="nav-item"><a href="#" class="nav-link">3. Input the ETE scores to the IER sheet.</a></li>
            <li class="nav-item"><a href="#" class="nav-link">4. Have applicant sign the IER sheet.</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><strong>Old Applications</strong></a></li>
            <li class="nav-item"><a href="#" class="nav-link">1. Take-in applications.</a></li>
            <li class="nav-item"><a href="#" class="nav-link">2. Only assess the ETE.</a></li>
            <li class="nav-item"><a href="#" class="nav-link">4. Input scores to the IER sheet.</a></li>
            <li class="nav-item"><a href="#" class="nav-link">3. Input Teach-Demo and Teacher-Reflection scores based on the RQA of the previous School Year to the EIR sheet. </a></li>
            <li class="nav-item"><a href="#" class="nav-link">4. Have applicant sign the IER sheet.</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><strong>Next Steps</strong></a></li>
            <li class="nav-item"><a href="#" class="nav-link">1. Plugin the scores to the HRMS System.</a></li>
            <li class="nav-item"><a href="#" class="nav-link">2. Print the CAR sheet and have it signed by the members of the school ranking committee.</a></li>
            <li class="nav-item"><a href="#" class="nav-link">3. Place the CAR sheet together with the signed IER files in a single folder per position.</a></li>
            <li class="nav-item"><a href="#" class="nav-link">4. Submit to SDO-HR unit.</a></li>
        </ul>
    </div>
</div>